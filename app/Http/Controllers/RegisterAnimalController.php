<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalReport;
use App\Models\Cage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterAnimalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW REGISTER ANIMAL PAGE
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | RESCUED REPORTS
        |--------------------------------------------------------------------------
        |
        | Only reports already marked "Rescued" can be used
        | for animal registration.
        |
        */

        $reports = AnimalReport::where('status', 'Rescued')
            ->whereNull('archived_at')
            ->orderByDesc('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | GET CAGES
        |--------------------------------------------------------------------------
        |
        | withCount('animals') gives us the current occupancy.
        | We do NOT store occupancy manually.
        |
        */

        $cages = Cage::withCount('animals')
            ->orderBy('animal_type')
            ->orderBy('cage_number')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | SELECTED REPORT
        |--------------------------------------------------------------------------
        */

        $selectedReportId =
            $request->query('report_id');

        $selectedReport = null;

        $selectedLocation = '';


        if ($selectedReportId) {

          $selectedReport = AnimalReport::where(
    'id',
    $selectedReportId
)
    ->whereNull('archived_at')
    ->first();
                


            if ($selectedReport) {

                $selectedLocation =
                    implode(', ', array_filter([

                        $selectedReport->house_street,

                        $selectedReport->barangay,

                        $selectedReport->city_municipality,

                        $selectedReport->province,

                        $selectedReport->region,

                    ]));
            }
        }


        return view(
            'admin.register-animal',
            compact(
                'reports',
                'cages',
                'selectedReportId',
                'selectedReport',
                'selectedLocation'
            )
        );
    }

public function edit($id)
{
    $animal = Animal::with(['cage', 'report'])
        ->findOrFail($id);

    $reports = AnimalReport::where('status', 'Rescued')
        ->whereNull('archived_at')
        ->orderByDesc('id')
        ->get();

    $cages = Cage::withCount('animals')
        ->orderBy('animal_type')
        ->orderBy('cage_number')
        ->get();

    $selectedReportId = $animal->report_id;

    $selectedReport = $animal->report;

    $selectedLocation = $animal->location_found ?? '';

    return view('admin.register-animal', [
        'animal' => $animal,
        'reports' => $reports,
        'cages' => $cages,
        'selectedReportId' => $selectedReportId,
        'selectedReport' => $selectedReport,
        'selectedLocation' => $selectedLocation,
        'editMode' => true,
    ]);
}

   

    public function report($id)
    {
        $report =
            AnimalReport::where(
                'id',
                $id
            )
            ->where('status', 'Rescued')
            ->whereNull('archived_at')
            ->firstOrFail();


        $location =
            implode(', ', array_filter([

                $report->house_street,

                $report->barangay,

                $report->city_municipality,

                $report->province,

                $report->region,

            ]));


        return response()->json([

            'id' =>
                $report->id,

            'report_id' =>
                'R-' .
                str_pad(
                    $report->id,
                    3,
                    '0',
                    STR_PAD_LEFT
                ),

            'reporter_name' =>
                trim(
                    $report->first_name .
                    ' ' .
                    $report->last_name
                ),

            'date_rescued' =>
                optional(
                    $report->created_at
                )->format('Y-m-d'),

            'location_found' =>
                $location,

            'rescue_notes' =>
                $report->additional_notes
                ?? '',

            'animal_type' =>
                $report->animal_type
                ?? '',

            'breed' =>
                $report->breed
                ?? '',

            'animal_image' =>
                $report->animal_image
                ?? null,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CAGE AVAILABILITY
    |--------------------------------------------------------------------------
    |
    | This is only for displaying cage information.
    | The final security check is still performed in store().
    |
    */

    public function cageAvailability($id)
    {
        $cage =
            Cage::withCount('animals')
                ->findOrFail($id);


        $occupied =
            (int) $cage->animals_count;

        $capacity =
            (int) $cage->capacity;

        $available =
            max(
                $capacity - $occupied,
                0
            );


        /*
        |--------------------------------------------------------------------------
        | DISPLAY STATUS
        |--------------------------------------------------------------------------
        */

        if ($cage->status === 'Maintenance') {

            $displayStatus =
                'Maintenance';

        } elseif ($occupied >= $capacity) {

            $displayStatus =
                'Full';

        } elseif ($occupied > 0) {

            $displayStatus =
                'Partially Filled';

        } else {

            $displayStatus =
                'Available';
        }


        return response()->json([

            'id' =>
                $cage->id,

            'cage_number' =>
                $cage->cage_number,

            'animal_type' =>
                $cage->animal_type,

            'capacity' =>
                $capacity,

            'occupied' =>
                $occupied,

            'available' =>
                $available,

            'status' =>
                $cage->status,

            'display_status' =>
                $displayStatus,

            'can_assign' =>
                $cage->status !== 'Maintenance'
                &&
                $occupied < $capacity,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | STORE ANIMAL
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                /*
                | Registration Source
                */

               'report_id' => [
    'nullable',
    'integer',
    'exists:animal_reports,id',
],

                /*
                | Basic Information
                */

                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'animal_type' => [
                    'required',
                    'in:Dog,Cat',
                ],

                'breed' => [
                    'required',
                    'string',
                    'max:255',
                ],

                /*
                | Keep your current age storage.
                | Your animals.age column is VARCHAR.
                */

                'age' => 'required|in:Young,Adult,Old',

                'gender' => [
                    'required',
                    'in:Male,Female',
                ],

                'weight' => [
                    'nullable',
                    'numeric',
                    'min:0',
                    'max:9999',
                ],

                'height' => [
                    'nullable',
                    'numeric',
                    'min:0',
                    'max:9999',
                ],


                /*
                | Rescue Information
                */

                'date_acquired' => [
                    'nullable',
                    'date',
                ],

                'location_found' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

                'health_condition' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'medical_notes' => [
                    'nullable',
                    'string',
                ],


                /*
                | Photo
                */

                'animal_image' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],


                /*
                | Cage
                */

                'cage_id' => [
                    'required',
                    'integer',
                    'exists:cages,id',
                ],


                /*
                | Status
                */

                'status' => [
                    'required',
                    'string',
                    'in:Registered,For Adoption,Under Treatment',
                ],


                /*
                | Vaccinations
                */

                'vaccinations' => [
    'nullable',
    'array'
],

'vaccinations.*' => [
    'nullable',
    'in:Given,Pending'
],

                'additional_notes' => [
                    'nullable',
                    'string',
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | ALWAYS INITIALIZE REPORT
        |--------------------------------------------------------------------------
        */

/*
|--------------------------------------------------------------------------
| CHECK RESCUE REPORT
|--------------------------------------------------------------------------
|
| The report relationship is now determined by report_id.
| There is no longer a visible "Registration Source" field.
|
*/

$report = null;

if (!empty($validated['report_id'])) {

    $report = AnimalReport::where(
        'id',
        $validated['report_id']
    )
        ->where('status', 'Rescued')
        ->whereNull('archived_at')
        ->first();

    if (!$report) {

        return back()
            ->withErrors([
                'report_id' =>
                    'The selected rescue report is no longer available.',
            ])
            ->withInput();
    }
}

        /*
        |--------------------------------------------------------------------------
        | SAVE EVERYTHING IN ONE TRANSACTION
        |--------------------------------------------------------------------------
        */

        try {

            DB::transaction(
                function () use (
                    $request,
                    $validated,
                    $report
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | LOCK THE CAGE
                    |--------------------------------------------------------------------------
                    |
                    | This prevents two registrations from using
                    | the same final cage slot at the same time.
                    |
                    */

                    $cage =
                        Cage::where(
                            'id',
                            $validated['cage_id']
                        )
                        ->lockForUpdate()
                        ->first();


                    /*
                    |--------------------------------------------------------------------------
                    | CAGE EXISTS
                    |--------------------------------------------------------------------------
                    */

                    if (!$cage) {

                        throw new \RuntimeException(
                            'The selected cage does not exist.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CAGE TYPE
                    |--------------------------------------------------------------------------
                    */

                    if (
                        strtolower(
                            $cage->animal_type
                        )
                        !==
                        strtolower(
                            $validated['animal_type']
                        )
                    ) {

                        throw new \RuntimeException(
                            'The selected cage is not intended for this animal type.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | MAINTENANCE
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $cage->status
                        ===
                        'Maintenance'
                    ) {

                        throw new \RuntimeException(
                            'The selected cage is currently under maintenance and cannot receive an animal.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CURRENT OCCUPANCY
                    |--------------------------------------------------------------------------
                    */

                    $occupied =
                        Animal::where(
                            'cage_id',
                            $cage->id
                        )->count();


                    /*
                    |--------------------------------------------------------------------------
                    | CAPACITY
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $occupied
                        >=
                        $cage->capacity
                    ) {

                        throw new \RuntimeException(
                            'The selected cage is already full.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PHOTO
                    |--------------------------------------------------------------------------
                    */

                    $imageName = null;


                    /*
                    | Rescue report already has an image.
                    | Use it automatically.
                    */
                  if (
    $report
    &&
    !empty($report->animal_image)
) {
    $imageName = $report->animal_image;
}


                    /*
                    | Admin replacement photo.
                    */

                    if (
                        $request->hasFile(
                            'animal_image'
                        )
                    ) {

                        $image =
                            $request->file(
                                'animal_image'
                            );


                        $uploadPath =
                            public_path(
                                'uploads/animals'
                            );


                        if (
                            !is_dir(
                                $uploadPath
                            )
                        ) {

                            mkdir(
                                $uploadPath,
                                0755,
                                true
                            );
                        }


                        $imageName =
                            time()
                            . '_'
                            . Str::slug(
                                pathinfo(
                                    $image
                                        ->getClientOriginalName(),
                                    PATHINFO_FILENAME
                                )
                            )
                            . '.'
                            . $image
                                ->getClientOriginalExtension();


                        $image->move(
                            $uploadPath,
                            $imageName
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | VACCINATIONS
                    |--------------------------------------------------------------------------
                    */

                    $vaccinations =
                        $validated[
                            'vaccinations'
                        ] ?? [];


                    /*
                    |--------------------------------------------------------------------------
                    | CREATE ANIMAL
                    |--------------------------------------------------------------------------
                    */

                    Animal::create([

                        'name' =>
                            trim(
                                $validated['name']
                            ),

                        'animal_type' =>
                            $validated[
                                'animal_type'
                            ],

                        'breed' =>
                            trim(
                                $validated['breed']
                            ),

                        'age' => $validated['age'],

                        'gender' =>
                            $validated['gender'],

                        'weight' =>
                            $validated['weight']
                            ?? null,

                        'height' =>
                            $validated['height']
                            ?? null,

                        'animal_image' =>
                            $imageName,

                       'source_type' =>
    !empty($validated['report_id'])
        ? 'Rescue Report'
        : 'Direct Registration',
                        'report_id' =>
                            $validated[
                                'report_id'
                            ] ?? null,

                     'date_acquired' =>
    $validated['date_acquired']
    ?? optional($report?->created_at)->format('Y-m-d')
    ?? now()->format('Y-m-d'),

'location_found' =>
    $validated['location_found']
    ?? (
        $report
            ? implode(', ', array_filter([
                $report->house_street,
                $report->barangay,
                $report->city_municipality,
                $report->province,
                $report->region,
            ]))
            : null
    ),

                        'health_condition' =>
                            $validated[
                                'health_condition'
                            ],

                        'medical_notes' =>
                            $validated[
                                'medical_notes'
                            ]
                            ?? null,

                        'vaccinations' =>
                            $vaccinations,

                        'status' =>
                            $validated[
                                'status'
                            ],

                        /*
                        |--------------------------------------------------------------------------
                        | THIS IS THE CAGE ASSIGNMENT
                        |--------------------------------------------------------------------------
                        */

                        'cage_id' =>
                            $cage->id,

                        'additional_notes' =>
                            $validated[
                                'additional_notes'
                            ]
                            ?? null,

                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | DO NOT CHANGE RESCUED REPORT STATUS
                    |--------------------------------------------------------------------------
                    |
                    | The report was already Rescued before registration.
                    |
                    */
                }
            );


            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */
            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */
            /* SUCCESS */
            return redirect()
                ->route(
                    'admin.register-animal'
                )
                ->with(
                    'success',
                    'Animal registered and assigned to the cage successfully.'
                );


        } catch (\Throwable $e) {

            return back()
                ->withErrors([
                    'cage_id' =>
                        $e->getMessage(),
                ])
                ->withInput();
        }
    }
    /*
|--------------------------------------------------------------------------
| UPDATE REGISTERED ANIMAL
|--------------------------------------------------------------------------
*/

public function update(Request $request, $id)
{
    $animal = Animal::findOrFail($id);

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate([

        'name' => [
            'required',
            'string',
            'max:255'
        ],

        'animal_type' => [
            'required',
            'in:Dog,Cat'
        ],

        'breed' => [
            'required',
            'string',
            'max:255'
        ],

        'age' => [
            'required',
            'in:Young,Adult,Old'
        ],

        'gender' => [
            'required',
            'in:Male,Female'
        ],

        'weight' => [
            'nullable',
            'numeric',
            'min:0',
            'max:9999'
        ],

        'height' => [
            'nullable',
            'numeric',
            'min:0',
            'max:9999'
        ],

        'date_acquired' => [
            'nullable',
            'date'
        ],

        'location_found' => [
            'nullable',
            'string',
            'max:1000'
        ],

        'health_condition' => [
            'required',
            'string',
            'max:255'
        ],

        'medical_notes' => [
            'nullable',
            'string'
        ],

        'animal_image' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:5120'
        ],

        'cage_id' => [
            'required',
            'integer',
            'exists:cages,id'
        ],

       'status' => [
    'required',
    'in:Registered,For Adoption,Under Treatment,Adopted'
],

        'vaccinations' => [
            'nullable',
            'array'
        ],

        'additional_notes' => [
            'nullable',
            'string'
        ],
    ]);


    /*
    |--------------------------------------------------------------------------
    | CHECK CAGE
    |--------------------------------------------------------------------------
    */

    $cage = Cage::findOrFail(
        $validated['cage_id']
    );


    /*
    |--------------------------------------------------------------------------
    | CAGE TYPE MUST MATCH ANIMAL TYPE
    |--------------------------------------------------------------------------
    */

    if (
        strtolower($cage->animal_type) !==
        strtolower($validated['animal_type'])
    ) {

        return back()
            ->withErrors([
                'cage_id' =>
                    'The selected cage is not intended for this animal type.'
            ])
            ->withInput();
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK CAGE CAPACITY
    |--------------------------------------------------------------------------
    |
    | If the animal stays in the same cage,
    | do NOT count itself as an extra occupant.
    |
    */

    $occupied = Animal::where(
        'cage_id',
        $cage->id
    )
    ->where(
        'id',
        '!=',
        $animal->id
    )
    ->count();


    if ($occupied >= $cage->capacity) {

        return back()
            ->withErrors([
                'cage_id' =>
                    'The selected cage is already full.'
            ])
            ->withInput();
    }


    /*
    |--------------------------------------------------------------------------
    | PHOTO
    |--------------------------------------------------------------------------
    */

    $imageName = $animal->animal_image;


    if ($request->hasFile('animal_image')) {

        $image = $request->file('animal_image');

        $imageName =
            time() . '_' .
            Str::slug(
                pathinfo(
                    $image->getClientOriginalName(),
                    PATHINFO_FILENAME
                )
            ) .
            '.' .
            $image->getClientOriginalExtension();

        $image->move(
            public_path('uploads/animals'),
            $imageName
        );
    }

$vaccinations = $validated['vaccinations'] ?? [];

$vaccinations = collect($vaccinations)
    ->filter(function ($value) {
        return $value !== null && trim((string) $value) !== '';
    })
    ->toArray();
    /*
    |--------------------------------------------------------------------------
    | UPDATE ANIMAL
    |--------------------------------------------------------------------------
    */

    $animal->update([

        'name' =>
            trim($validated['name']),

        'animal_type' =>
            $validated['animal_type'],

        'breed' =>
            trim($validated['breed']),

        'age' =>
            $validated['age'],

        'gender' =>
            $validated['gender'],

        'weight' =>
            $validated['weight'] ?? null,

        'height' =>
            $validated['height'] ?? null,

        'animal_image' =>
            $imageName,

        'date_acquired' =>
            $validated['date_acquired']
            ?? $animal->date_acquired,

        'location_found' =>
            $validated['location_found'] ?? null,

        'health_condition' =>
            $validated['health_condition'],

        'medical_notes' =>
            $validated['medical_notes'] ?? null,

        'vaccinations' => $vaccinations,

        'status' =>
            $validated['status'],

        'cage_id' =>
            $validated['cage_id'],

        'additional_notes' =>
            $validated['additional_notes'] ?? null,
    ]);


    /*
    |--------------------------------------------------------------------------
    | RETURN
    |--------------------------------------------------------------------------
    */

       /*
    |--------------------------------------------------------------------------
    | RETURN
    |--------------------------------------------------------------------------
    */

    $editRoute = strtolower(trim($animal->animal_type)) === 'cat'
        ? 'admin.registered-cats.edit'
        : 'admin.registered-dogs.edit';

    return redirect()
        ->route($editRoute, $animal->id)
        ->with(
            'success',
            'Animal information updated successfully.'
        );
}
}