<?php


namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AdoptionApplication;
   
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Mail\AdoptionApprovedMail;
use App\Mail\AdoptionRejectedMail;

class AdoptionController extends Controller
{
    public function showApplication(Animal $animal)
{
    // Check if the animal is available for adoption.
    if (strtolower(trim($animal->status)) !== 'for adoption') {
        return redirect()
            ->route('adoption')
            ->with('error', 'This animal is no longer available for adoption.');
    }

    // Return to the existing adoption page.
    return redirect()->route('adoption');
}
    // ... existing methods (index, show, showApplication, submitApplication, manageAdoptions, completeAdoptions, completeAdoption, viewAdoptionValidId, showCompleteAdoption, saveAdoptionMonitoring)

public function submitApplication(Request $request, Animal $animal)
{
    /* =========================================================
       CHECK ANIMAL STATUS
    ========================================================= */
    if (strtolower(trim($animal->status)) !== 'for adoption') {
        return back()->withErrors([
            'animal' => 'This animal is no longer available for adoption.'
        ]);
    }

    /* =========================================================
       CHECK DUPLICATE APPLICATION
    ========================================================= */
    $existingApplication = AdoptionApplication::where('user_id', Auth::id())
        ->where('animal_id', $animal->id)
        ->whereIn('status', ['Pending', 'Approved'])
        ->exists();

    if ($existingApplication) {
        return back()->withErrors([
            'application' => 'You already have an active application for this animal.'
        ]);
    }

    /* =========================================================
       VALIDATION
    ========================================================= */
    $validated = $request->validate([
        'occupation' => ['required', 'string', 'max:100'],
        'civil_status' => ['required', 'string', 'max:50'],

        'house_street' => ['required', 'string', 'max:255'],
        'region' => ['required', 'string', 'max:150'],
        'province' => ['required', 'string', 'max:150'],
        'city_municipality' => ['required', 'string', 'max:150'],
       'barangay' => 'required|string|max:255',

        'reason_for_adoption' => ['required', 'in:Companion,Family,Rescue Support,Personal Interest,Other'],
        'reason_explanation' => ['nullable', 'string', 'max:2000'],
        'primary_responsible' => ['required', 'in:Myself,My spouse/partner,Parent/guardian,Another household member,Other'],
        'primary_responsible_other' => ['nullable', 'string', 'max:255'],

        'residence_type' => ['required', 'in:Owned house,Rented house,Apartment/Condominium,Boarding house,Other'],
        'residence_other' => ['nullable', 'string', 'max:255'],
        'landlord_permission' => ['required', 'in:Yes,No,Not applicable'],
        'household_members' => ['required', 'integer', 'min:1', 'max:100'],
        'household_support' => ['required', 'in:Yes,No'],

        'commitment_food_shelter_care' => ['accepted'],
        'commitment_veterinary_care' => ['accepted'],
        'commitment_safety' => ['accepted'],
        'commitment_policies' => ['accepted'],
        'commitment_post_adoption' => ['accepted'],

        'valid_id' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],

        'agreement_information' => ['accepted'],
        'agreement_not_automatic' => ['accepted'],
        'agreement_policies' => ['accepted'],
    ], [
        'valid_id.required' => 'Please upload a valid government-issued ID.',
        'valid_id.mimes' => 'The ID must be JPG, JPEG, PNG, or PDF.',
        'valid_id.max' => 'The ID file must not exceed 5 MB.',
        'commitment_food_shelter_care.accepted' => 'You must agree to provide proper food, shelter, care, and attention.',
        'commitment_veterinary_care.accepted' => 'You must agree to provide necessary veterinary care.',
        'commitment_safety.accepted' => 'You must agree to keep the animal safe.',
        'commitment_policies.accepted' => 'You must agree to comply with adoption policies.',
        'commitment_post_adoption.accepted' => 'You must agree to post-adoption monitoring.',
        'agreement_information.accepted' => 'Please confirm that your information is true.',
        'agreement_not_automatic.accepted' => 'Please acknowledge that submission does not mean approval.',
        'agreement_policies.accepted' => 'Please agree to the Animal Rescue PH policies.',
    ]);

    /* =========================================================
       CONDITIONAL VALIDATION
    ========================================================= */
    if ($validated['primary_responsible'] === 'Other' &&
        empty(trim($validated['primary_responsible_other'] ?? ''))) {
        return back()->withErrors([
            'primary_responsible_other' => 'Please specify who will be responsible.'
        ])->withInput();
    }

    if ($validated['residence_type'] === 'Other' &&
        empty(trim($validated['residence_other'] ?? ''))) {
        return back()->withErrors([
            'residence_other' => 'Please specify your residence type.'
        ])->withInput();
    }

    if ($validated['residence_type'] === 'Rented house' &&
        $validated['landlord_permission'] === 'No') {
        return back()->withErrors([
            'landlord_permission' => 'You need permission from your landlord before proceeding.'
        ])->withInput();
    }

    if ($validated['household_support'] === 'No') {
        return back()->withErrors([
            'household_support' => 'All household members should be aware of and supportive of the adoption.'
        ])->withInput();
    }

    /* =========================================================
       SAVE ID
    ========================================================= */
    $idFile = $request->file('valid_id');
    $idFileName = time() . '_' . Str::random(12) . '.' . $idFile->getClientOriginalExtension();
    $idPath = $idFile->storeAs('adoption-ids', $idFileName, 'local');

    /* =========================================================
       APPLICANT INFO FROM USERS TABLE
    ========================================================= */
    $user = Auth::user();
    $fullName = trim($user->name ?? '');
    $nameParts = preg_split('/\s+/', $fullName, 2);
    $firstName = $nameParts[0] ?? '';
    $lastName = $nameParts[1] ?? '';
    $email = $user->email ?? '';
    $contactNumber = $user->phone ?? '';

    /* =========================================================
       CREATE APPLICATION
    ========================================================= */
    DB::transaction(function () use (
        $validated, $animal, $idPath, $idFile,
        $firstName, $lastName, $email, $contactNumber
    ) {
        AdoptionApplication::create([
            'user_id' => Auth::id(),
            'animal_id' => $animal->id,

            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'contact_number' => $contactNumber,

            'occupation' => $validated['occupation'],
            'civil_status' => $validated['civil_status'],

            'house_street' => $validated['house_street'],
            'region' => $validated['region'],
            'province' => $validated['province'],
            'city_municipality' => $validated['city_municipality'],
            'barangay' => $validated['barangay'] ?? null,
            'zip_code' => null,

            'reason_for_adoption' => $validated['reason_for_adoption'],
            'reason_explanation' => $validated['reason_explanation'] ?? null,
            'primary_responsible' => $validated['primary_responsible'],
            'primary_responsible_other' => $validated['primary_responsible_other'] ?? null,

            'residence_type' => $validated['residence_type'],
            'residence_other' => $validated['residence_other'] ?? null,
            'landlord_permission' => $validated['landlord_permission'],
            'household_members' => $validated['household_members'],
            'household_support' => $validated['household_support'],

            'commitment_food_shelter_care' => true,
            'commitment_veterinary_care' => true,
            'commitment_safety' => true,
            'commitment_policies' => true,
            'commitment_post_adoption' => true,

            'valid_id_path' => $idPath,
            'valid_id_original_name' => $idFile->getClientOriginalName(),
            'id_verification_status' => 'pending',

            'status' => 'Pending',

            'agreement_information' => true,
            'agreement_not_automatic' => true,
            'agreement_policies' => true,

            'submitted_at' => now(),
        ]);
    });

    return redirect()
        ->route('adoption')
        ->with('success', 'Your adoption application has been submitted successfully and is now pending review.');
}
    /* =========================================================
       APPROVE ADOPTION
       - Application: Pending → Approved
       - Animal: For Adoption → Pending Adoption (hide sa user page)
       - Auto-reject ibang pending applications para sa parehong hayop
    ========================================================= */
    public function viewAdoptionValidId(AdoptionApplication $application)
{
    if (!$application->valid_id_path) {
        abort(404, 'Valid ID not found.');
    }

    $disk = Storage::disk('local');

    if (!$disk->exists($application->valid_id_path)) {
        abort(404, 'File does not exist on storage.');
    }

    $path = $disk->path($application->valid_id_path);

    return response()->file($path, [
        'Content-Type' => mime_content_type($path),
        'Content-Disposition' => 'inline; filename="' . 
            basename($application->valid_id_original_name ?? 'valid-id') . 
            '"',
    ]);
}
    public function approveAdoption(AdoptionApplication $application)
    {
        if ($application->status !== 'Pending') {
            return back()->with('error', 'Only pending applications can be approved.');
        }

        DB::transaction(function () use ($application) {

            $application->update([
                'status' => 'Approved'
            ]);

            // I-hide ang animal sa user listing
            if ($application->animal) {
                $application->animal->update([
                    'status' => 'Pending Adoption'
                ]);
            }

            // Auto-reject ibang pending applications
            AdoptionApplication::where('animal_id', $application->animal_id)
                ->where('id', '!=', $application->id)
                ->where('status', 'Pending')
                ->update([
                    'status' => 'Rejected',
                    'rejection_reason' => 'Another applicant has been approved for this animal.',
                    'updated_at' => now(),
                ]);
        });

        if (!empty($application->email)) {
            Mail::to($application->email)->send(
                new AdoptionApprovedMail($application)
            );
        }

        return back()->with(
            'success',
            'Application approved. The animal is now reserved and hidden from the adoption gallery.'
        );
    }


    /* =========================================================
       REJECT ADOPTION
       - Pwede para sa Pending AT Approved applications
       - Kung Approved ang ni-reject, ibabalik ang animal sa gallery
    ========================================================= */
    public function rejectAdoption(Request $request, AdoptionApplication $application)
    {
        if (!in_array($application->status, ['Pending', 'Approved'])) {
            return back()->with(
                'error',
                'Only pending or approved applications can be rejected.'
            );
        }

        $data = $request->validate([
            'rejection_reason' => ['required', 'string', 'min:10', 'max:500'],
        ], [
            'rejection_reason.required' => 'Please provide a reason for rejecting this adoption application.',
            'rejection_reason.min' => 'The rejection reason must be at least 10 characters.',
            'rejection_reason.max' => 'The rejection reason must not exceed 500 characters.',
        ]);

        DB::transaction(function () use ($application, $data) {

            $application->update([
                'status' => 'Rejected',
                'rejection_reason' => $data['rejection_reason'],
            ]);

            // ✅ IBALIK ang animal sa gallery kung may animal
            if ($application->animal) {

                // Check kung may iba pang Approved/Completed na application
                $hasOtherActive = AdoptionApplication::where('animal_id', $application->animal_id)
                    ->where('id', '!=', $application->id)
                    ->whereIn('status', ['Approved', 'Completed'])
                    ->exists();

                // Kung wala nang ibang active, ibalik sa listing
                if (!$hasOtherActive) {
                    $application->animal->update([
                        'status' => 'For Adoption'
                    ]);
                }
            }
        });

        if (!empty($application->email)) {
            Mail::to($application->email)->send(
                new AdoptionRejectedMail($application)
            );
        }

        return back()->with(
            'success',
            'Application rejected. The animal is now back in the adoption gallery.'
        );
    }
        /**
     * Display the Manage Adoptions page for Admin.
     */public function index(Request $request)
{
    $query = Animal::query()
        ->whereRaw('LOWER(TRIM(status)) = ?', ['for adoption']);

    if ($request->filled('animal_type')) {
        $animalType = strtolower(trim($request->animal_type));
        $query->whereRaw('LOWER(TRIM(animal_type)) = ?', [$animalType]);
    }

    if ($request->filled('breed')) {
        $breed = strtolower(trim($request->breed));
        $query->whereRaw('LOWER(TRIM(breed)) = ?', [$breed]);
    }

    $animals = $query->latest('id')->get();

    $breeds = Animal::query()
        ->whereRaw('LOWER(TRIM(status)) = ?', ['for adoption'])
        ->whereNotNull('breed')
        ->whereRaw("TRIM(breed) != ''")
        ->select('breed')
        ->distinct()
        ->orderBy('breed')
        ->pluck('breed');

    $breedRecords = Animal::query()
        ->whereRaw('LOWER(TRIM(status)) = ?', ['for adoption'])
        ->whereNotNull('animal_type')
        ->whereRaw("TRIM(animal_type) != ''")
        ->whereNotNull('breed')
        ->whereRaw("TRIM(breed) != ''")
        ->select('animal_type', 'breed')
        ->orderBy('animal_type')
        ->orderBy('breed')
        ->get();

    $breedsByType = $breedRecords
        ->groupBy(function ($animal) {
            return strtolower(trim($animal->animal_type));
        })
        ->map(function ($animals) {
            return $animals->pluck('breed')->filter()->unique()->sort()->values()->toArray();
        })
        ->toArray();

    $animalTypes = Animal::query()
        ->whereRaw('LOWER(TRIM(status)) = ?', ['for adoption'])
        ->whereNotNull('animal_type')
        ->whereRaw("TRIM(animal_type) != ''")
        ->select('animal_type')
        ->distinct()
        ->orderBy('animal_type')
        ->pluck('animal_type');

    return view('adoption', compact('animals', 'breeds', 'animalTypes', 'breedsByType'));
}
/* =========================================================
   SHOW COMPLETE ADOPTION PAGE
   - Nagpapakita ng 4-week monitoring form
   - Tinatawag kapag pinindot ang "Complete" button
========================================================= */
public function completeAdoption(AdoptionApplication $application)
{
    /*
    |--------------------------------------------------------------------------
    | ONLY APPROVED APPLICATIONS CAN BE COMPLETED
    |--------------------------------------------------------------------------
    */

    if ($application->status !== 'Approved') {
        return back()->with(
            'error',
            'Only approved applications can be completed.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK ASSOCIATED ANIMAL
    |--------------------------------------------------------------------------
    */

    if (!$application->animal) {
        return back()->with(
            'error',
            'This adoption application has no associated animal.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | COMPLETE ADOPTION
    |--------------------------------------------------------------------------
    */

    DB::transaction(function () use ($application) {

        /*
        | Application
        | Approved → Completed
        */

        $application->update([
            'status' => 'Completed',
        ]);


        /*
        | Animal
        | Current status → Adopted
        | Cage assignment → Released
        */

        $application->animal->update([
            'status' => 'Adopted',
            'cage_id' => null,
        ]);

    });


    /*
    |--------------------------------------------------------------------------
    | RETURN TO MANAGE ADOPTIONS
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route(
            'admin.manage-adoptions',
            ['status' => 'Completed']
        )
        ->with(
            'success',
            'The adoption has been completed successfully. The application is now Completed and the animal is now Adopted.'
        );
}
public function downloadAdoption(AdoptionApplication $application)
{
    $application->load(['animal', 'user']);

    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Adoption Application #' . $application->id . '</title>
        <style>
            * { box-sizing: border-box; }
            body { font-family: Arial, sans-serif; color: #111; padding: 40px; max-width: 900px; margin: 0 auto; line-height: 1.6; }
            .header { text-align: center; border-bottom: 3px solid #f97316; padding-bottom: 20px; margin-bottom: 30px; }
            .header h1 { color: #f97316; margin: 0 0 5px; font-size: 28px; }
            .header p { margin: 0; color: #666; font-size: 14px; }
            .section { margin-bottom: 24px; padding: 16px 20px; border: 1px solid #e5e7eb; border-radius: 10px; }
            .section h2 { color: #f97316; font-size: 16px; margin: 0 0 14px; padding-bottom: 8px; border-bottom: 1px solid #f3f4f6; text-transform: uppercase; letter-spacing: 1px; }
            .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px 24px; }
            .item { padding: 4px 0; }
            .item .label { display: block; color: #666; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px; font-weight: 700; }
            .item .value { display: block; color: #111; font-size: 14px; font-weight: 600; }
            .full { grid-column: 1 / -1; }
            .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #e5e7eb; text-align: center; color: #999; font-size: 12px; }
            .status-badge { display: inline-block; padding: 6px 14px; border-radius: 20px; font-weight: 700; font-size: 12px; background: #e4f7ec; color: #198754; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>Animal Rescue PH</h1>
            <p>Adoption Application Report</p>
        </div>

        <div style="text-align: center; margin-bottom: 30px;">
            <div style="font-size: 24px; font-weight: 800;">Application #' . str_pad($application->id, 5, '0', STR_PAD_LEFT) . '</div>
            <div style="margin-top: 8px;"><span class="status-badge">' . $application->status . '</span></div>
            <div style="margin-top: 8px; color: #666; font-size: 13px;">
                Submitted: ' . ($application->submitted_at ? $application->submitted_at->format('F d, Y h:i A') : 'N/A') . '
            </div>
        </div>

        <div class="section">
            <h2>Applicant Information</h2>
            <div class="grid">
                <div class="item"><span class="label">Full Name</span><span class="value">' . htmlspecialchars($application->first_name . ' ' . $application->last_name) . '</span></div>
                <div class="item"><span class="label">Email</span><span class="value">' . htmlspecialchars($application->email ?? '—') . '</span></div>
                <div class="item"><span class="label">Contact Number</span><span class="value">' . htmlspecialchars($application->contact_number ?? '—') . '</span></div>
                <div class="item"><span class="label">Occupation</span><span class="value">' . htmlspecialchars($application->occupation ?? '—') . '</span></div>
                <div class="item"><span class="label">Civil Status</span><span class="value">' . htmlspecialchars($application->civil_status ?? '—') . '</span></div>
            </div>
        </div>

        ' . ($application->animal ? '
        <div class="section">
            <h2>Animal Information</h2>
            <div class="grid">
                <div class="item"><span class="label">Name</span><span class="value">' . htmlspecialchars($application->animal->name ?? '—') . '</span></div>
                <div class="item"><span class="label">Type</span><span class="value">' . htmlspecialchars($application->animal->animal_type ?? '—') . '</span></div>
                <div class="item"><span class="label">Breed</span><span class="value">' . htmlspecialchars($application->animal->breed ?? '—') . '</span></div>
                <div class="item"><span class="label">Gender</span><span class="value">' . htmlspecialchars($application->animal->gender ?? '—') . '</span></div>
                <div class="item"><span class="label">Age</span><span class="value">' . htmlspecialchars($application->animal->age ?? '—') . '</span></div>
                <div class="item"><span class="label">Animal Status</span><span class="value">' . htmlspecialchars($application->animal->status ?? '—') . '</span></div>
            </div>
        </div>
        ' : '') . '

        <div class="section">
            <h2>Complete Address</h2>
            <div class="grid">
                <div class="item full"><span class="label">House / Unit / Street</span><span class="value">' . htmlspecialchars($application->house_street ?? '—') . '</span></div>
                <div class="item"><span class="label">Region</span><span class="value">' . htmlspecialchars($application->region ?? '—') . '</span></div>
                <div class="item"><span class="label">Province</span><span class="value">' . htmlspecialchars($application->province ?? '—') . '</span></div>
                <div class="item"><span class="label">City / Municipality</span><span class="value">' . htmlspecialchars($application->city_municipality ?? '—') . '</span></div>
                <div class="item"><span class="label">Barangay</span><span class="value">' . htmlspecialchars($application->barangay ?? '—') . '</span></div>
            </div>
        </div>

        <div class="section">
            <h2>Adoption Background</h2>
            <div class="grid">
                <div class="item full"><span class="label">Reason for Adoption</span><span class="value">' . htmlspecialchars($application->reason_for_adoption ?? '—') . '</span></div>
                <div class="item full"><span class="label">Explanation</span><span class="value">' . htmlspecialchars($application->reason_explanation ?? '—') . '</span></div>
                <div class="item"><span class="label">Primary Responsible</span><span class="value">' . htmlspecialchars($application->primary_responsible ?? '—') . '</span></div>
                <div class="item"><span class="label">Residence Type</span><span class="value">' . htmlspecialchars($application->residence_type ?? '—') . '</span></div>
                <div class="item"><span class="label">Household Members</span><span class="value">' . htmlspecialchars($application->household_members ?? '—') . '</span></div>
                <div class="item"><span class="label">Household Support</span><span class="value">' . htmlspecialchars($application->household_support ?? '—') . '</span></div>
            </div>
        </div>

        <div class="footer">
            <p>Generated by Animal Rescue PH — Adoption Management System</p>
            <p>Generated on ' . now()->format('F d, Y h:i A') . '</p>
        </div>
    </body>
    </html>
    ';

       return response($html)
        ->header('Content-Type', 'application/octet-stream')
        ->header(
            'Content-Disposition',
            'attachment; filename="adoption-application-' . $application->id . '.html"'
        );
}
    public function manageAdoptions(Request $request)
    {
        $status = $request->get('status', 'Pending');
        $search = trim($request->get('search', ''));

        /*
        |--------------------------------------------------------------------------
        | COUNTS (Para sa Summary Cards at Status Tabs)
        |--------------------------------------------------------------------------
        */
   $counts = [
    'all'       => AdoptionApplication::where('status', '!=', 'Completed')
                        ->whereNull('archived_at')
                        ->count(),
    'pending'   => AdoptionApplication::where('status', 'Pending')
                        ->whereNull('archived_at')->count(),
    'approved'  => AdoptionApplication::where('status', 'Approved')
                        ->whereNull('archived_at')->count(),
    'rejected'  => AdoptionApplication::where('status', 'Rejected')
                        ->whereNull('archived_at')->count(),
    'completed' => AdoptionApplication::where('status', 'Completed')
                        ->whereNull('archived_at')->count(),
];

        /*
        |--------------------------------------------------------------------------
        | APPLICATION QUERY
        |--------------------------------------------------------------------------
        */
     $query = AdoptionApplication::with('animal')
    ->whereNull('archived_at');
        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */
       if ($status === 'All') {
    // Sa "All" tab — EXCLUDE Completed
    $query->where('status', '!=', 'Completed');
} elseif (in_array($status, ['Pending', 'Approved', 'Rejected', 'Completed'], true)) {
    // Sa specific tabs — EXACT match
    $query->where('status', $status);
}
        /*
        |--------------------------------------------------------------------------
        | SEARCH FILTER
        |--------------------------------------------------------------------------
        */
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%")
                  ->orWhereHas('animal', function ($animalQuery) use ($search) {
                      $animalQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('breed', 'like', "%{$search}%");
                  });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | ORDER & PAGINATE
        |--------------------------------------------------------------------------
        */
        $applications = $query
            ->orderByDesc('created_at')
            ->paginate(8)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */
        return view('admin.manage-adoptions', compact(
            'applications',
            'counts',
            'status',
            'search'
        ));
    }

   public function archiveAdoption($application)
{
    $application = \App\Models\AdoptionApplication::findOrFail($application);

    if ($application->status !== 'Rejected') {
        return back()->with('error', 'Only rejected applications can be archived.');
    }

    $application->update([
        'archived_at' => now(),
    ]);

    return redirect()
        ->route('admin.manage-adoptions', ['status' => 'Rejected'])
        ->with('success', '✅ Rejected application moved to Archive successfully.');
}
}