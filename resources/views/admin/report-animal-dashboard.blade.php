<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Animal Reports - Admin
    </title>


    <!-- BOOTSTRAP -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- BOOTSTRAP ICONS -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >


    <!-- FONT AWESOME -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >


    <!-- LEAFLET -->

    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    >


    <!-- CUSTOM CSS -->

    <link
        rel="stylesheet"
        href="{{ asset('css/report-animal-dashboard.css') }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('css/admin-dashboard.css') }}"
    >
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css"
>

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css"
>
</head>


<body>


<!-- =========================================================
     SIDEBAR
========================================================= -->

<!-- SIDEBAR -->
<aside class="sidebar">

    <!-- LOGO -->
    <div class="sidebar-logo">
        <img
            src="{{ asset('images/logo.png') }}"
            alt="Animal Rescue PH"
        >
    </div>

    <!-- ORGANIZATION -->
    <div class="organization">
        <h2>Animal Rescue PH</h2>
       
    </div>

    <!-- NAVIGATION -->
    <nav class="sidebar-navigation">

        <!-- DASHBOARD -->
        <a
            href="{{ route('admin.dashboard') }}"
            class="sidebar-link"
        >
            <i class="bi bi-house-fill"></i>
            <span>Dashboard</span>
        </a>

        <!-- REPORTS -->
        <a
            href="{{ route('admin.report-animal') }}"
            class="sidebar-link active"
        >
            <i class="bi bi-file-earmark-text-fill"></i>
            <span>Reports</span>
        </a>

        <!-- MANAGE ANIMALS -->
        <a
             href="{{ route('admin.manage-animals') }}"
            class="sidebar-link"
        >
            <i class="bi bi-heart-pulse-fill"></i>
            <span>Manage Animals</span>
        </a>

        <!-- MANAGE ADOPTIONS -->
         <a
                href="{{ route('admin.manage-adoptions') }}"
                class="sidebar-link "
            >
            <i class="bi bi-heart-fill"></i>
            <span>Manage Adoptions</span>
        </a>

    </nav>

    <!-- LOGOUT -->
    <div class="sidebar-bottom">

        <form
            action="{{ route('logout') }}"
            method="POST"
        >
            @csrf

            <button
                type="submit"
                class="logout-link"
            >
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>

    </div>

</aside>


<!-- =========================================================
     MAIN
========================================================= -->

<main class="admin-main">


    <!-- HEADER -->

    <header class="dashboard-header">

        <div>

            <h1>
                Animal <span>Reports</span>
            </h1>

            <p>
                Manage and review submitted animal rescue reports.
            </p>

        </div>


<div class="admin-badge">

    <button type="button" class="admin-trigger" id="adminTrigger">

        <i class="bi bi-person-fill"></i>

        <span>Admin</span>

        <i class="bi bi-chevron-down admin-chevron"></i>

    </button>


    <div class="admin-dropdown" id="adminDropdown">

        <div class="account-header">

            <div class="account-avatar">
                <i class="bi bi-person-fill"></i>
            </div>

            <div class="account-details">

                <strong>
                    {{ auth()->user()->name ?? 'Admin' }}
                </strong>

                <span>
                    {{ auth()->user()->email ?? 'No email' }}
                </span>

            </div>

        </div>


        <div class="account-divider"></div>


        <div class="account-role">

            <i class="bi bi-shield-check"></i>

            <span>
                {{ ucfirst(auth()->user()->role ?? 'Admin') }}
            </span>

        </div>
        <a href="{{ route('admin.archive') }}" class="account-archive">
    <i class="bi bi-archive-fill"></i>
    <span>Archive</span>
</a>
@if (strtolower(auth()->user()->role ?? '') === 'owner')
    <a href="{{ route('admin.staff.index') }}"
       class="account-archive">
        <i class="bi bi-people-fill"></i>
        <span>Manage Admin Accounts</span>
    </a>
@endif


        <div class="account-divider"></div>


        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button type="submit" class="account-logout">

                <i class="bi bi-box-arrow-right"></i>

                <span>Logout</span>

            </button>

        </form>

    </div>

</div>


        </div>


    </header>



    <!-- =====================================================
         SUCCESS MESSAGE
    ====================================================== -->

    @if(session('success'))

        <div class="alert alert-success">

            <i class="bi bi-check-circle-fill"></i>

            {{ session('success') }}

        </div>

    @endif



    <!-- =====================================================
         STATISTICS
    ====================================================== -->

    <section class="statistics-grid">


        <div class="stat-card">

            <div class="stat-icon">
                <i class="bi bi-file-earmark-text-fill"></i>
            </div>

            <div>

                <h2>
                    Total Reports
                </h2>

                <strong>
                    {{ $totalReports }}
                </strong>

            </div>

        </div>



        <div class="stat-card pending">

            <div class="stat-icon">
                <i class="bi bi-clock-fill"></i>
            </div>

            <div>

                <h2>
                    Pending
</h2>

                <strong>
                    {{ $pendingReports }}
                </strong>

            </div>

        </div>



        <div class="stat-card approved">

            <div class="stat-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div>

                <h2>
                    Approved
</h2>

                <strong>
                    {{ $approvedReports }}
                </strong>

            </div>

        </div>



        <div class="stat-card rejected">

            <div class="stat-icon">
                <i class="bi bi-x-circle-fill"></i>
            </div>

            <div>

                <h2>
                   
                    Rejected
</h2>

                <strong>
                    {{ $rejectedReports }}
                </strong>

            </div>

        </div>


    </section>



    <!-- =====================================================
         REPORT MANAGEMENT
    ====================================================== -->

    <section class="report-management">


        <!-- FILTER HEADER -->

        <div class="management-header">


            <div>

                <h2>
                    Report Management
                </h2>

                <p>
                    Review animal rescue submissions.
                </p>

            </div>


            <!-- SEARCH -->

           <div class="management-actions">

    <button
        type="button"
        class="view-all-map-btn"
        onclick="openAllReportsMap()"
    >
        <i class="bi bi-map-fill"></i>
        View All Reports on Map
    </button>

</div>

        </div>



        <!-- =================================================
             FILTER TABS
        ================================================== -->

        <div class="report-tabs">

            <a
                href="{{ route('admin.report-animal', ['status' => 'all']) }}"
                class="{{ request('status', 'all') === 'all' ? 'active' : '' }}"
            >
                All
            </a>


            <a
                href="{{ route('admin.report-animal', ['status' => 'pending']) }}"
                class="{{ request('status') === 'pending' ? 'active' : '' }}"
            >
                Pending
            </a>


            <a
                href="{{ route('admin.report-animal', ['status' => 'approved']) }}"
                class="{{ request('status') === 'approved' ? 'active' : '' }}"
            >
                Approved
            </a>


            <a
                href="{{ route('admin.report-animal', ['status' => 'rejected']) }}"
                class="{{ request('status') === 'rejected' ? 'active' : '' }}"
            >
                Rejected
            </a>

        </div>



        <!-- =================================================
             TABLE
        ================================================== -->

        <div class="table-responsive">

            <table class="reports-table">

                <thead>

                    <tr>

                        <th>
                            Animal
                        </th>

                        <th>
                            Breed
                        </th>

                        <th>
                            Location
                        </th>

                        <th>
                            Reporter
                        </th>

                        <th>
                            Date
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @forelse($reports as $report)

                        <tr>


                            <!-- ANIMAL -->

                            <td>

                                <div class="animal-cell">

                                    @if($report->animal_image)

                                        <img
                                            src="{{ asset('uploads/animals/' . $report->animal_image) }}"
                                            alt="Animal"
                                        >

                                    @else

                                        <div class="no-image">

                                            <i class="bi bi-image"></i>

                                        </div>

                                    @endif


                                    <div>

                                        <strong>
                                            {{ $report->animal_type }}
                                        </strong>

                                        

                                    </div>

                                </div>

                            </td>



                            <!-- BREED -->

                         <td class="breed-cell">
    {{ $report->breed ?: 'Unknown' }}
</td>



                            <!-- LOCATION -->

                            <td>

                              
<button
    type="button"
    class="map-button"
    data-lat="{{ $report->latitude }}"
    data-lng="{{ $report->longitude }}"
    data-address="{{ $report->house_street }}, {{ $report->barangay }}, {{ $report->city_municipality }}, {{ $report->province }}"
    onclick="openMap(
        this.dataset.lat,
        this.dataset.lng,
        this.dataset.address
    )"
>
    <i class="bi bi-geo-alt-fill"></i>
    View on Map
</button>
                                </div>

                            </td>



                            <!-- REPORTER -->

                            <td>

                                <div class="reporter-cell">

                                    <strong>

                                        {{ $report->first_name }}
                                        {{ $report->last_name }}

                                    </strong>

                                   
                                </div>

                            </td>



                            <!-- DATE -->

                            <!-- DATE -->
<td class="date-cell">
    {{ $report->created_at->format('M d, Y') }}
</td>



                            <!-- STATUS -->

                            <td>

                               <span class="status-badge status-{{ strtolower($report->status) }}">
    {{ ucfirst(strtolower($report->status)) }}
</span>
                            </td>



                            <!-- ACTIONS -->

                            

<td>

    <div class="action-buttons">

        {{-- VIEW REPORT --}}
        <button
            type="button"
            class="action-btn view"
            data-bs-toggle="modal"
            data-bs-target="#viewReportModal"

            data-image="{{ $report->animal_image }}"
            data-type="{{ $report->animal_type }}"
            data-breed="{{ $report->breed }}"
            data-confidence="{{ $report->confidence }}"
            data-location="{{ $report->house_street }}, {{ $report->barangay }}, {{ $report->city_municipality }}, {{ $report->province }}"
            data-contact="{{ $report->contact_number }}"
            data-name="{{ $report->first_name }} {{ $report->last_name }}"
            data-email="{{ $report->email }}"
            data-notes="{{ $report->additional_notes }}"
            data-date="{{ $report->created_at->format('F d, Y h:i A') }}"
        >

            <i class="bi bi-eye-fill"></i>

        </button>


        {{-- =====================================================
             PENDING
        ====================================================== --}}

        @if(strtolower($report->status) === 'pending')

            {{-- APPROVE --}}
            <form
                action="{{ route(
                    'admin.report-animal.status',
                    $report->id
                ) }}"
                method="POST"
                style="display:inline;"
            >

                @csrf

                <input
                    type="hidden"
                    name="status"
                    value="Approved"
                >

                <button
                    type="submit"
                    class="action-btn approve"
                    title="Approve Report"
                >
                    Approve
                </button>

            </form>


            {{-- REJECT --}}
          {{-- REJECT --}}
<button
    type="button"
    class="action-btn reject"
    title="Reject Report"
    data-bs-toggle="modal"
    data-bs-target="#rejectReportModal"
    data-report-id="{{ $report->id }}"
    data-report-name="{{ $report->first_name }} {{ $report->last_name }}"
    onclick="setRejectFormAction(this)"
>
    Reject
</button>

        {{-- =====================================================
             APPROVED
        ====================================================== --}}

        @elseif(strtolower($report->status) === 'approved')

            {{-- RESCUE --}}
            <form
                action="{{ route(
                    'admin.report-animal.status',
                    $report->id
                ) }}"
                method="POST"
                style="display:inline;"
            >

                @csrf

                <input
                    type="hidden"
                    name="status"
                    value="Rescued"
                >

                <button
                    type="submit"
                    class="action-btn rescue"
                    title="Mark as Rescued"
                >

                    <i class="bi bi-heart-fill"></i>

                </button>

            </form>

{{-- REJECT --}}
<button
    type="button"
    class="action-btn reject"
    title="Reject Report"
    data-bs-toggle="modal"
    data-bs-target="#rejectReportModal"
    data-report-id="{{ $report->id }}"
    data-report-name="{{ $report->first_name }} {{ $report->last_name }}"
    onclick="setRejectFormAction(this)"
>
    Reject
</button>

        {{-- =====================================================
             REJECTED
        ====================================================== --}}

        @elseif(strtolower($report->status) === 'rejected')

            {{-- ARCHIVE --}}
            <form
                action="{{ route(
                    'admin.report-animal.archive',
                    $report->id
                ) }}"
                method="POST"
                style="display:inline;"
            >

                @csrf

              <button
    type="button"
    class="action-btn archive"
    title="Move to Archive"
    data-bs-toggle="modal"
    data-bs-target="#archiveReportModal"
    data-report-id="{{ $report->id }}"
    data-report-name="{{ $report->animal_type }} - {{ $report->breed }}"
>
    <i class="bi bi-archive-fill"></i>
</button>

            </form>

        @endif

    </div>

</td>     

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="empty-state"
                            >

                                <i class="bi bi-inbox"></i>

                                <h4>
                                    No Reports Found
                                </h4>

                                <p>
                                    There are no animal reports matching your search.
                                </p>

                            </td>

                        </tr>

                    @endforelse


                </tbody>

            </table>

        </div>



        <!-- PAGINATION -->

        <div class="pagination-wrapper">

            {{ $reports->links() }}

        </div>


    </section>

</main>


<!-- =========================================================
     REJECT REPORT MODAL
========================================================= -->

<div
    class="modal fade"
    id="rejectReportModal"
    tabindex="-1"
    aria-labelledby="rejectReportModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <!-- HEADER -->

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="rejectReportModalLabel"
                >
                    <i class="bi bi-x-circle-fill text-danger"></i>

                    Reject Rescue Report
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <!-- BODY -->

            <div class="modal-body">

                <div class="reject-warning">

                    <i class="bi bi-exclamation-triangle-fill"></i>

                    <div>

                        <strong>
                            Are you sure you want to reject this report?
                        </strong>

                        <p id="rejectReporterName">
                            Please provide a reason for the rejection.
                        </p>

                    </div>

                </div>


                <!-- REJECTION FORM -->
<form
    id="rejectReportForm"
    method="POST"
    action="#"
>
    @csrf

    <input
        type="hidden"
        name="status"
        value="Rejected"
    >


<div class="form-group">

    <label for="rejection_reason">
        Reason for Rejection
        <span>*</span>
    </label>

    {{-- PREDEFINED REASONS --}}
    <select
        id="rejection_reason_select"
        class="form-control"
    >
        <option value="">
            Select a reason
        </option>

        {{-- COMMUNICATION / CONTACT --}}
        <option value="The rescue team could not communicate with the reporter despite reasonable attempts to contact them.">
            Unable to communicate with reporter
        </option>

        <option value="The reporter could not be reached using the contact information provided in the rescue report.">
            Reporter could not be reached
        </option>

        <option value="The contact information provided by the reporter is invalid, incomplete, or unreachable.">
            Invalid or unreachable contact information
        </option>

        {{-- LOCATION / ACCESS --}}
        <option value="The reported rescue location could not be verified by the rescue team.">
            Rescue location could not be verified
        </option>

        <option value="The reported location is inaccessible or cannot currently be reached by the rescue team.">
            Location is inaccessible
        </option>

    

        <option value="The submitted animal photo is unclear or does not provide enough information for proper assessment.">
            Unclear or insufficient animal photo
        </option>

        <option value="The reported animal could not be confirmed based on the submitted information and available evidence.">
            Animal could not be confirmed
        </option>

        

        {{-- OPERATIONAL --}}
        <option value="The rescue request is outside the current service area of Animal Rescue PH.">
            Outside rescue service area
        </option>

        <option value="The rescue team is unable to proceed because the situation requires resources or assistance that are currently unavailable.">
            Required rescue resources unavailable
        </option>

        <option value="The rescue request cannot currently be accommodated due to operational limitations.">
            Operational limitations
        </option>

        {{-- OTHER --}}
        <option value="other">
            Other reason
        </option>
    </select>


    {{-- OPTIONAL CUSTOM REASON --}}
    <textarea
        id="custom_rejection_reason"
        class="form-control"
        rows="4"
        maxlength="1000"
        placeholder="Enter your own reason..."
        style="display: none; margin-top: 12px;"
    ></textarea>


    {{-- ACTUAL VALUE SENT TO CONTROLLER --}}
   
<input
    type="hidden"
    id="rejection_reason"
    name="rejection_reason"
>
    <small class="text-muted">
        Select the most appropriate reason for rejecting this rescue report.
        Choose "Other reason" if the appropriate reason is not listed.
    </small>

</div>

                </form>

            </div>


            <!-- FOOTER -->

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    form="rejectReportForm"
                    class="btn btn-danger"
                >
                    <i class="bi bi-x-circle-fill"></i>

                    Confirm Reject
                </button>

            </div>

        </div>

    </div>

</div>
<!-- =========================================================
     VIEW REPORT MODAL
========================================================= -->

<div
    class="modal fade"
    id="viewReportModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">


            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="bi bi-file-earmark-text-fill"></i>

                    Animal Report Details

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <div class="modal-body">


                <div class="report-details-grid">


                    <div class="report-image-wrapper">

                        <img
                            id="modalAnimalImage"
                            src=""
                            alt="Animal"
                        >

                    </div>



                    <div class="report-details">


                        <div class="detail-item">

                            <span>
                                Animal Type
                            </span>

                            <strong id="modalAnimalType">
                            </strong>

                        </div>


                        <div class="detail-item">

                            <span>
                                Breed
                            </span>

                            <strong id="modalBreed">
                            </strong>

                        </div>


                        <div class="detail-item">

                            <span>
                                Accuracy
                            </span>

                            <strong id="modalConfidence">
                            </strong>

                        </div>


                        <div class="detail-item">

                            <span>
                                Reporter
                            </span>

                            <strong id="modalReporter">
                            </strong>

                        </div>


                        <div class="detail-item">

                            <span>
                                Email
                            </span>

                            <strong id="modalEmail">
                            </strong>

                        </div>


                        <div class="detail-item">

                            <span>
                                Contact
                            </span>

                            <strong id="modalContact">
                            </strong>

                        </div>


                        <div class="detail-item full">

                            <span>
                                Location
                            </span>

                            <strong id="modalLocation">
                            </strong>

                        </div>


                        <div class="detail-item full">

                            <span>
                                Additional Notes
                            </span>

                            <p id="modalNotes">
                            </p>

                        </div>


                        <div class="detail-item full">

                            <span>
                                Date Submitted
                            </span>

                            <strong id="modalDate">
                            </strong>

                        </div>


                    </div>

                </div>


            </div>

        </div>

    </div>

</div>

<!-- =========================================================
     ALL REPORTS MAP MODAL
========================================================= -->

<div
    class="modal fade"
    id="allReportsMapModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="bi bi-map-fill"></i>
                    Animal Reports Map
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <div class="modal-body p-0">

                <div
    id="allReportsMap"
    class="all-reports-map-container"
></div>

            </div>

            <div class="modal-footer">

                <span class="map-legend">
                    <i class="bi bi-geo-alt-fill"></i>
                    Each marker represents an animal report.
                </span>

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>

            </div>

        </div>

    </div>

</div>

<!-- =========================================================
     MAP MODAL
========================================================= -->
<!-- =========================================================
     INDIVIDUAL REPORT MAP MODAL
========================================================= -->

<div
    class="modal fade"
    id="mapModal"
    tabindex="-1"
    aria-hidden="true"
>
    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="bi bi-geo-alt-fill"></i>
                    Report Location
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <div class="modal-body p-0">

                <div
                    id="reportMap"
                    class="report-map-container"
                ></div>

            </div>

            <div class="modal-footer">

                <div
                    id="mapAddress"
                    class="map-address"
                >
                    Report location
                </div>

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>

            </div>

        </div>

    </div>
</div>
<!-- =========================================================
     ARCHIVE CONFIRMATION MODAL
========================================================= -->

<div
    class="modal fade"
    id="archiveReportModal"
    tabindex="-1"
    aria-labelledby="archiveReportModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content archive-modal">

            <!-- Header -->
            <div class="archive-modal-header">

                <div class="archive-modal-icon">
                    <i class="bi bi-archive-fill"></i>
                </div>

                <button
                    type="button"
                    class="archive-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >
                    <i class="bi bi-x-lg"></i>
                </button>

            </div>


            <!-- Body -->
            <div class="archive-modal-body">

                <h3 id="archiveReportModalLabel">
                    Move to Archive?
                </h3>

                <p class="archive-modal-description">
                    Are you sure you want to move this rejected
                    animal report to Archive?
                </p>


                <!-- Selected report -->
                <div class="archive-report-preview">

                    <div class="archive-preview-icon">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>

                    <div class="archive-preview-text">

                        <span>
                            Selected Report
                        </span>

                        <strong id="archiveReportName">
                            Animal Report
                        </strong>

                    </div>

                </div>


                <!-- Information -->
                <div class="archive-info">

                    <i class="bi bi-info-circle-fill"></i>

                    <p>
                        This report will be moved to Archive.
                        It will <strong>not be permanently deleted</strong>
                        and can remain there until you permanently delete it.
                    </p>

                </div>

            </div>


            <!-- Footer -->
            <div class="archive-modal-footer">

                <button
                    type="button"
                    class="archive-cancel-btn"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>


                <form
                    id="archiveReportForm"
                    method="POST"
                    style="margin: 0;"
                >

                    @csrf

                    <button
                        type="submit"
                        class="archive-confirm-btn"
                    >
                        <i class="bi bi-archive-fill"></i>
                        Move to Archive
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const archiveModal = document.getElementById('archiveReportModal');

    if (!archiveModal) {
        return;
    }

    archiveModal.addEventListener(
        'show.bs.modal',
        function (event) {

            const button = event.relatedTarget;

            if (!button) {
                return;
            }

            const reportId = button.getAttribute(
                'data-report-id'
            );

            const reportName = button.getAttribute(
                'data-report-name'
            );

            const form = document.getElementById(
                'archiveReportForm'
            );

            const reportNameElement = document.getElementById(
                'archiveReportName'
            );


            /*
            |--------------------------------------------------------------------------
            | SET REPORT NAME
            |--------------------------------------------------------------------------
            */

            if (reportNameElement) {

                reportNameElement.textContent =
                    reportName || 'Animal Report';

            }


            /*
            |--------------------------------------------------------------------------
            | SET FORM ACTION
            |--------------------------------------------------------------------------
            */

            if (form && reportId) {

                form.action =
                    `/admin/report-animal/${reportId}/archive`;

            }

        }
    );

});
</script>
<!-- BOOTSTRAP -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

<!-- LEAFLET -->
<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
></script>

<!-- MARKER CLUSTER -->
<script
    src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"
></script>

<!-- REPORT DATA -->
<script id="allReportsData" type="application/json">
    @json($mapReports)
</script>

<!-- YOUR JAVASCRIPT -->
<script
    src="{{ asset('js/report-animal-dashboard.js') }}"
></script>

</body>

</html>