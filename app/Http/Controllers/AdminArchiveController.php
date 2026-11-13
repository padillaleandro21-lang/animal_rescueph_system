<?php

namespace App\Http\Controllers;

use App\Models\AnimalReport;
use App\Models\AdoptionApplication;
use Illuminate\Http\Request;
class AdminArchiveController extends Controller
{
    /*
|--------------------------------------------------------------------------
| ARCHIVE REJECTED REPORT
|--------------------------------------------------------------------------
|
| Moves a rejected report to the Archive by setting archived_at.
| It does NOT permanently delete the report.
|
*/
public function deleteReport(int $id)
{
    $report = AnimalReport::findOrFail($id);

    $report->delete();

    return redirect()
        ->route('admin.archive')
        ->with(
            'success',
            'Rejected animal report permanently deleted.'
        );
}

public function archive($id)
{
    $report = AnimalReport::findOrFail($id);

    // Only rejected reports can be archived
    if (strtolower(trim($report->status)) !== 'rejected') {
        return redirect()
            ->back()
            ->with(
                'error',
                'Only rejected reports can be moved to Archive.'
            );
    }

    // Mark the report as archived
    $report->archived_at = now();

    $report->save();

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
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | REJECTED RESCUE REPORTS
        |--------------------------------------------------------------------------
        */

        $reports = AnimalReport::whereNotNull('archived_at')
            ->whereRaw(
                'LOWER(TRIM(status)) = ?',
                ['rejected']
            )
            ->latest('archived_at')
            ->paginate(
                10,
                ['*'],
                'reports_page'
            );


        /*
        |--------------------------------------------------------------------------
        | REJECTED ADOPTION APPLICATIONS
        |--------------------------------------------------------------------------
        */

        $applications = AdoptionApplication::with([
                'animal',
                'user'
            ])
            ->whereNotNull('archived_at')
            ->whereRaw(
                'LOWER(TRIM(status)) = ?',
                ['rejected']
            )
            ->latest('archived_at')
            ->paginate(
                10,
                ['*'],
                'applications_page'
            );


        /*
        |--------------------------------------------------------------------------
        | ARCHIVE VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.archive',
            compact(
                'reports',
                'applications'
            )
        );
    }
    /*
|--------------------------------------------------------------------------
| PERMANENTLY DELETE ARCHIVED ADOPTION APPLICATION
|--------------------------------------------------------------------------
|
| Removes the application from the database permanently.
| This cannot be undone.
|
*/
public function deleteApplication(int $id)
{
    $application = AdoptionApplication::findOrFail($id);

    // Only allow deleting archived applications
    if (is_null($application->archived_at)) {
        return redirect()
            ->route('admin.archive')
            ->with(
                'error',
                'This application is not archived. Cannot delete.'
            );
    }

    $application->delete();

    return redirect()
        ->route('admin.archive')
        ->with(
            'success',
            'Archived adoption application permanently deleted.'
        );
}
}