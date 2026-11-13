<?php

namespace App\Http\Controllers;

use App\Models\AnimalReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Mail\RescueReportApprovedMail;
use App\Mail\RescueReportRejectedMail;
use App\Mail\RescueReportRescuedMail;

class AdminReportAnimalController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | REPORTS
        |--------------------------------------------------------------------------
        */

        $query = AnimalReport::query()
            ->whereNull('archived_at');


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'animal_type',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'breed',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'first_name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'last_name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'barangay',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'city_municipality',
                    'like',
                    "%{$search}%"
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

    $status = ucfirst(
        strtolower($request->status)
    );

    if (
        in_array(
            $status,
            [
                'Pending',
                'Approved',
                'Rejected',
                'Rescued'
            ]
        )
    ) {

        // Specific status tab
        $query->where(
            'status',
            $status
        );

    } else {

        // ALL tab
        $query->whereRaw(
            'LOWER(TRIM(status)) != ?',
            ['rescued']
        );
    }

} else {

    // ALL tab when no status parameter exists
    $query->whereRaw(
        'LOWER(TRIM(status)) != ?',
        ['rescued']
    );
}


        /*
        |--------------------------------------------------------------------------
        | REPORT LIST
        |--------------------------------------------------------------------------
        */
$reports = $query
    ->orderByRaw("
        CASE LOWER(TRIM(status))
            WHEN 'pending' THEN 1
            WHEN 'approved' THEN 2
            WHEN 'rescued' THEN 3
            WHEN 'rejected' THEN 4
            ELSE 5
        END
    ")
    ->latest('created_at')
    ->paginate(10)
    ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | STATISTICS
        |--------------------------------------------------------------------------
        */

        $totalReports = AnimalReport::whereNull('archived_at')
    ->whereRaw('LOWER(TRIM(status)) = ?', ['pending'])
    ->count();


        $pendingReports = AnimalReport::whereNull(
            'archived_at'
        )
        ->where(
            'status',
            'Pending'
        )
        ->count();


        $approvedReports = AnimalReport::whereNull(
            'archived_at'
        )
        ->where(
            'status',
            'Approved'
        )
        ->count();


        $rejectedReports = AnimalReport::whereNull(
            'archived_at'
        )
        ->where(
            'status',
            'Rejected'
        )
        ->count();


        /*
        |--------------------------------------------------------------------------
        | MAP REPORTS
        |--------------------------------------------------------------------------
        |
        | Only active Pending and Approved reports
        | with valid coordinates appear on the map.
        |
        */

        $mapReports = AnimalReport::whereNull('archived_at')
            ->whereIn(
                'status',
                [
                    'Pending',
                    'Approved'
                ]
            )
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get([
                'id',
                'first_name',
                'last_name',
                'contact_number',
                'house_street',
                'barangay',
                'city_municipality',
                'province',
                'animal_type',
                'breed',
                'confidence',
                'status',
                'latitude',
                'longitude',
            ]);


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.report-animal-dashboard',
            compact(
                'reports',
                'totalReports',
                'pendingReports',
                'approvedReports',
                'rejectedReports',
                'mapReports'
            )
        );
    }

public function updateStatus(
    Request $request,
    AnimalReport $report
) {
    $validated = $request->validate([
        'status' => [
            'required',
            'in:Pending,Approved,Rejected,Rescued'
        ],

        'rejection_reason' => [
            'nullable',
            'string',
            'min:10',
            'max:1000'
        ],
    ]);

    $newStatus = $validated['status'];
    $currentStatus = $report->status;

    /*
    |--------------------------------------------------------------------------
    | ALLOWED STATUS FLOW
    |--------------------------------------------------------------------------
    |
    | Pending  → Approved
    | Pending  → Rejected
    |
    | Approved → Rescued
    | Approved → Rejected
    |
    */

    $allowed = match ($currentStatus) {

        'Pending' => [
            'Approved',
            'Rejected'
        ],

        'Approved' => [
            'Rescued',
            'Rejected'
        ],

        default => [],
    };

    /*
    |--------------------------------------------------------------------------
    | CHECK STATUS FLOW
    |--------------------------------------------------------------------------
    */

    if (!in_array($newStatus, $allowed, true)) {

        return back()->with(
            'error',
            'This status change is not allowed.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REJECTION REASON
    |--------------------------------------------------------------------------
    */

    if ($newStatus === 'Rejected') {

        if (empty($validated['rejection_reason'])) {

            return back()->with(
                'error',
                'Please provide a reason for rejecting this report.'
            );
        }

        $report->rejection_reason =
            $validated['rejection_reason'];

    } else {

        $report->rejection_reason = null;
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS
    |--------------------------------------------------------------------------
    */

    $report->status = $newStatus;

    $report->save();


    /*
    |--------------------------------------------------------------------------
    | SEND EMAIL NOTIFICATION
    |--------------------------------------------------------------------------
    */

    if (!empty($report->email)) {

        try {

            if ($newStatus === 'Approved') {

                Mail::to($report->email)
                    ->send(
                        new RescueReportApprovedMail($report)
                    );
            }


            if ($newStatus === 'Rejected') {

                Mail::to($report->email)
                    ->send(
                        new RescueReportRejectedMail($report)
                    );
            }


            if ($newStatus === 'Rescued') {

                Mail::to($report->email)
                    ->send(
                        new RescueReportRescuedMail($report)
                    );
            }

        } catch (\Throwable $e) {

           Log::error(
    'Rescue report email failed',
    [
        'report_id' => $report->id,
        'email' => $report->email,
        'status' => $newStatus,
        'error' => $e->getMessage(),
    ]
);

        }
    }


    /*
    |--------------------------------------------------------------------------
    | SUCCESS MESSAGE
    |--------------------------------------------------------------------------
    */

    if ($newStatus === 'Rescued') {
    return redirect()
        ->back()
        ->with(
            'success',
            'Animal successfully rescued and moved to Manage Animals.'
        );
}

    if ($newStatus === 'Approved') {

        return back()->with(
            'success',
            'Report approved successfully. The user has been notified by email.'
        );
    }


    if ($newStatus === 'Rejected') {

        return back()->with(
            'success',
            'Report rejected successfully. The user has been notified by email.'
        );
    }


    return back()->with(
        'success',
        'Report status updated successfully.'
    );
}
/*
|--------------------------------------------------------------------------
| ARCHIVE REJECTED REPORT
|--------------------------------------------------------------------------
|
| This does NOT delete the report.
| It only sets archived_at so the report moves
| from the normal report page to the Archive page.
|
*/

public function archive(AnimalReport $report)
{
    /*
    |--------------------------------------------------------------------------
    | ONLY REJECTED REPORTS CAN BE ARCHIVED
    |--------------------------------------------------------------------------
    */

    if (strtolower(trim($report->status)) !== 'rejected') {

        return back()->with(
            'error',
            'Only rejected reports can be moved to Archive.'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | MOVE TO ARCHIVE
    |--------------------------------------------------------------------------
    */

    $report->archived_at = now();

    $report->save();


    /*
    |--------------------------------------------------------------------------
    | RETURN TO REJECTED REPORTS
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route(
            'admin.report-animal',
            ['status' => 'rejected']
        )
        ->with(
            'success',
            'Rejected animal report moved to Archive successfully.'
        );
}
}