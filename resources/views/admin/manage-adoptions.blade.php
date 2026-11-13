<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Manage Adoptions </title>

    {{-- BOOTSTRAP --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- BOOTSTRAP ICONS --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
<link
        rel="stylesheet"
        href="{{ asset('css/admin-dashboard.css') }}"
    >

    {{-- ADMIN CSS --}}
    <link
        rel="stylesheet"
        href="{{ asset('css/manage-adoptions.css') }}"
    >

    
   
</head>

<body>

<div class="dashboard-wrapper">

    {{-- =========================================================
         SIDEBAR
    ========================================================== --}}

    <aside class="sidebar">

        <div class="sidebar-logo">

            <img
                src="{{ asset('images/logo.png') }}"
                alt="Animal Rescue PH"
            >

        </div>

        <div class="organization">

            <h2>Animal Rescue PH</h2>

           

        </div>

        <nav class="sidebar-navigation">

            <a
                href="{{ route('admin.dashboard') }}"
                class="sidebar-link"
            >
                <i class="bi bi-house-fill"></i>
                <span>Dashboard</span>
            </a>

            <a
                href="{{ route('admin.report-animal') }}"
                class="sidebar-link"
            >
                <i class="bi bi-file-earmark-text-fill"></i>
                <span>Reports</span>
            </a>

            <a
                href="{{ route('admin.manage-animals') }}"
                class="sidebar-link"
            >
                <i class="bi bi-heart-pulse-fill"></i>
                <span>Manage Animals</span>
            </a>

            <a
                href="{{ route('admin.manage-adoptions') }}"
                class="sidebar-link active"
            >
                <i class="bi bi-heart-fill"></i>
                <span>Manage Adoptions</span>
            </a>

        </nav>

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


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <main class="main-content">

        {{-- PAGE HEADER --}}

        <div class="dashboard-header">

            <div>

                <h1>Manage <span>Adoptions</span></h1>

                <p>
                    Review and manage submitted adoption applications.
                </p>

            </div>

            <div class="admin-badge">

    <button
        type="button"
        class="admin-trigger"
        id="adminTrigger"
        aria-expanded="false"
    >

        <i class="bi bi-person-fill"></i>

        <span>Admin</span>

        <i class="bi bi-chevron-down admin-chevron"></i>

    </button>


    <div
        class="admin-dropdown"
        id="adminDropdown"
    >

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


        <a
            href="{{ route('admin.archive') }}"
            class="account-archive"
        >

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


        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="account-logout"
            >

                <i class="bi bi-box-arrow-right"></i>

                <span>Logout</span>

            </button>

        </form>

    </div>

</div>


        {{-- SUCCESS --}}

        @if(session('success'))

            <div class="alert-box success-alert">

                <i class="bi bi-check-circle-fill"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif


        {{-- ERROR --}}

        @if(session('error'))

            <div class="alert-box error-alert">

                <i class="bi bi-exclamation-circle-fill"></i>

                <span>
                    {{ session('error') }}
                </span>

            </div>

        @endif


        {{-- VALIDATION --}}

        @if($errors->any())

            <div class="alert-box error-alert">

                <i class="bi bi-exclamation-triangle-fill"></i>

                <div>

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            </div>

        @endif


        {{-- =========================================================
             SUMMARY
        ========================================================== --}}

        <section class="summary-grid">

            <div class="summary-card summary-all">

                <div class="summary-icon">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>

                <div>

                    <span>Total Applications</span>

                    <strong>
                        {{ $counts['all'] }}
                    </strong>

                    <small>
                        All adoption applications
                    </small>

                </div>

            </div>


            <div class="summary-card summary-pending">

                <div class="summary-icon">
                    <i class="bi bi-clock-fill"></i>
                </div>

                <div>

                    <span>Pending</span>

                    <strong>
                        {{ $counts['pending'] }}
                    </strong>

                    <small>
                        Applications for review
                    </small>

                </div>

            </div>


            <div class="summary-card summary-approved">

                <div class="summary-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <div>

                    <span>Approved</span>

                    <strong>
                        {{ $counts['approved'] }}
                    </strong>

                    <small>
                        Approved applications
                    </small>

                </div>

            </div>


            <div class="summary-card summary-rejected">

                <div class="summary-icon">
                    <i class="bi bi-x-circle-fill"></i>
                </div>

                <div>

                    <span>Rejected</span>

                    <strong>
                        {{ $counts['rejected'] }}
                    </strong>

                    <small>
                        Rejected applications
                    </small>

                </div>

            </div>


            <div class="summary-card summary-completed">

                <div class="summary-icon">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <div>

                    <span>Completed</span>

                    <strong>
                        {{ $counts['completed'] ?? 0 }}
                    </strong>

                    <small>
                        Finalized adoptions
                    </small>

                </div>

            </div>

        </section>


        {{-- =========================================================
             APPLICATION PANEL
        ========================================================== --}}

        <section class="application-panel">

            <div class="panel-heading">

                <div>

                    <h2>Adoption Applications</h2>

                    <p>
                        Manage and review adoption form submissions.
                    </p>

                </div>


                <div class="panel-tools">

                    {{-- SEARCH --}}

                    <form
                        action="{{ route('admin.manage-adoptions') }}"
                        method="GET"
                        class="search-form"
                    >

                        <input
                            type="hidden"
                            name="status"
                            value="{{ $status }}"
                        >

                        <i class="bi bi-search"></i>

                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search applicant, pet name, or email..."
                        >

                        <button
                            type="submit"
                            class="search-button"
                        >
                            <i class="bi bi-search"></i>
                        </button>

                    </form>
                    
{{-- MONTHLY ADOPTION CSV EXPORT --}}
<form
    action="{{ route('admin.adoptions.export-monthly') }}"
    method="GET"
    class="adoption-export-form"
>
    <select name="month" aria-label="Select month" required>
        @foreach(range(1, 12) as $month)
            <option
                value="{{ $month }}"
                {{ (int) request('month', now()->month) === $month ? 'selected' : '' }}
            >
                {{ \Carbon\Carbon::create()->month($month)->format('F') }}
            </option>
        @endforeach
    </select>

    <select name="year" aria-label="Select year" required>
        @foreach(range(2024, now()->year) as $year)
            <option
                value="{{ $year }}"
                {{ (int) request('year', now()->year) === $year ? 'selected' : '' }}
            >
                {{ $year }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="adoption-export-btn">
        <i class="bi bi-file-earmark-spreadsheet"></i>
        Export 
    </button>
</form>


                </div>

            </div>


            {{-- =========================================================
                 STATUS TABS
            ========================================================== --}}

            <div class="status-tabs">

                <a
                    href="{{ route(
                        'admin.manage-adoptions',
                        [
                            'status' => 'All',
                            'search' => $search
                        ]
                    ) }}"
                    class="{{ $status === 'All' ? 'active' : '' }}"
                >
                    All
                    <span>
                        ({{ $counts['all'] }})
                    </span>
                </a>


                <a
                    href="{{ route(
                        'admin.manage-adoptions',
                        [
                            'status' => 'Pending',
                            'search' => $search
                        ]
                    ) }}"
                    class="{{ $status === 'Pending' ? 'active' : '' }}"
                >
                    Pending
                    <span>
                        ({{ $counts['pending'] }})
                    </span>
                </a>


                <a
                    href="{{ route(
                        'admin.manage-adoptions',
                        [
                            'status' => 'Approved',
                            'search' => $search
                        ]
                    ) }}"
                    class="{{ $status === 'Approved' ? 'active' : '' }}"
                >
                    Approved
                    <span>
                        ({{ $counts['approved'] }})
                    </span>
                </a>


                <a
                    href="{{ route(
                        'admin.manage-adoptions',
                        [
                            'status' => 'Rejected',
                            'search' => $search
                        ]
                    ) }}"
                    class="{{ $status === 'Rejected' ? 'active' : '' }}"
                >
                    Rejected
                    <span>
                        ({{ $counts['rejected'] }})
                    </span>
                </a>


                <a
                    href="{{ route(
                        'admin.manage-adoptions',
                        [
                            'status' => 'Completed',
                            'search' => $search
                        ]
                    ) }}"
                    class="{{ $status === 'Completed' ? 'active' : '' }}"
                >
                    Completed
                    <span>
                        ({{ $counts['completed'] }})
                    </span>
                </a>

            </div>


            {{-- =========================================================
                 TABLE
            ========================================================== --}}

            <div class="table-wrapper">

                <table class="applications-table">

                    <thead>

                        <tr>

                            <th>Applicant</th>

                            <th>Pet</th>

                            <th>Contact</th>

                            <th>Date Submitted</th>

                            <th>Status</th>

                            <th>Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($applications as $application)

                            @php

                                $fullName = trim(
                                    ($application->first_name ?? '') .
                                    ' ' .
                                    ($application->last_name ?? '')
                                );

                                if ($fullName === '') {
                                    $fullName = 'Unknown Applicant';
                                }

                                $firstInitial = substr(
                                    $application->first_name ?? '',
                                    0,
                                    1
                                );

                                $lastInitial = substr(
                                    $application->last_name ?? '',
                                    0,
                                    1
                                );

                                $initials = strtoupper(
                                    $firstInitial . $lastInitial
                                );

                                if ($initials === '') {
                                    $initials = 'A';
                                }

                                $statusClass = strtolower(
                                    str_replace(
                                        ' ',
                                        '-',
                                        $application->status ?? ''
                                    )
                                );

                                $applicationData = [
                                    'id' =>
                                        $application->id,

                                    'first_name' =>
                                        $application->first_name,

                                    'last_name' =>
                                        $application->last_name,

                                    'email' =>
                                        $application->email,

                                    'contact_number' =>
                                        $application->contact_number,

                                    'occupation' =>
                                        $application->occupation,

                                    'civil_status' =>
                                        $application->civil_status,

                                    'house_street' =>
                                        $application->house_street,

                                    'region' =>
                                        $application->region,

                                    'province' =>
                                        $application->province,

                                    'city_municipality' =>
                                        $application->city_municipality,

                                    'barangay' =>
                                        $application->barangay,

                                    'reason_for_adoption' =>
                                        $application->reason_for_adoption,

                                    'reason_explanation' =>
                                        $application->reason_explanation,

                                    'primary_responsible' =>
                                        $application->primary_responsible,

                                    'primary_responsible_other' =>
                                        $application->primary_responsible_other,

                                    'residence_type' =>
                                        $application->residence_type,

                                    'residence_other' =>
                                        $application->residence_other,

                                    'household_members' =>
                                        $application->household_members,

                                    'household_support' =>
                                        $application->household_support,

                                    'valid_id_original_name' =>
                                        $application->valid_id_original_name,

                                    'status' =>
                                        $application->status,
                                ];


                                $animalData =
                                    $application->animal
                                        ? [

                                            'name' =>
                                                $application->animal->name,

                                            'animal_type' =>
                                                $application->animal->animal_type,

                                            'breed' =>
                                                $application->animal->breed,

                                            'gender' =>
                                                $application->animal->gender,

                                            'age' =>
                                                $application->animal->age,

                                            'status' =>
                                                $application->animal->status,

                                            'animal_image' =>
                                                $application->animal->animal_image,

                                        ]
                                        : null;

                            @endphp


                            <tr>

                                {{-- APPLICANT --}}

                                <td>

                                    <div class="applicant-cell">

                                        <div class="applicant-avatar">
                                            {{ $initials }}
                                        </div>

                                        <div class="applicant-info">

                                            <strong>
                                                {{ $fullName }}
                                            </strong>

                                            <span>
                                                {{ $application->email ?? '—' }}
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                {{-- PET --}}

                                <td>

                                    <div class="pet-cell">

                                        @if(
                                            $application->animal &&
                                            $application->animal->animal_image
                                        )

                                            <img
                                                src="{{ asset(
                                                    'uploads/animals/' .
                                                    $application->animal->animal_image
                                                ) }}"
                                                alt="{{ $application->animal->name ?? 'Animal' }}"
                                            >

                                        @else

                                            <div class="pet-placeholder">
                                                <i class="bi bi-image"></i>
                                            </div>

                                        @endif


                                        <div>

                                            <strong>
                                                {{ $application->animal->name ?? 'Unknown' }}
                                            </strong>

                                            <span>

                                                {{ $application->animal->animal_type ?? '—' }}

                                                @if(
                                                    $application->animal &&
                                                    $application->animal->breed
                                                )

                                                   

                                                    {{ $application->animal->breed }}

                                                @endif

                                            </span>

                                        </div>

                                    </div>

                                </td>


                                {{-- CONTACT --}}

                                <td>

                                    <span class="contact-value">
                                        {{ $application->contact_number ?? '—' }}
                                    </span>

                                </td>


                                {{-- DATE --}}

                                <td>

                                    @php

                                        $submittedDate =
                                            $application->submitted_at ??
                                            $application->created_at;

                                    @endphp

                                    <div class="date-cell">

                                        <strong>

                                            {{
                                                $submittedDate
                                                    ? $submittedDate->format('M d, Y')
                                                    : '—'
                                            }}

                                        </strong>

                                        <span>

                                            {{
                                                $submittedDate
                                                    ? $submittedDate->format('h:i A')
                                                    : ''
                                            }}

                                        </span>

                                    </div>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    <span
                                        class="status-badge {{ $statusClass }}"
                                    >

                                        @if($application->status === 'Pending')

                                            <i class="bi bi-clock-fill"></i>

                                        @elseif($application->status === 'Approved')

                                            <i class="bi bi-check-circle-fill"></i>

                                        @elseif($application->status === 'Rejected')

                                            <i class="bi bi-x-circle-fill"></i>

                                        @elseif($application->status === 'Completed')

                                            <i class="bi bi-check2-circle"></i>

                                        @else

                                            <i class="bi bi-info-circle-fill"></i>

                                        @endif

                                        {{ $application->status }}

                                    </span>

                                </td>


                                {{-- ACTIONS --}}

                               
{{-- =================================================
     ACTIONS
================================================== --}}
<td>
    <div class="action-buttons">

        {{-- VIEW APPLICATION: AVAILABLE FOR ALL STATUSES --}}
        <button
            type="button"
            class="action-btn view-btn"
            title="View Adoption Application"
            data-application='@json($applicationData)'
            data-animal='@json($animalData)'
            data-valid-id-url="{{ route(
                'admin.adoption.valid-id',
                $application->id
            ) }}"
        >
            <i class="bi bi-eye-fill"></i>
            View
        </button>


        {{-- PENDING: APPROVE AND REJECT --}}
       
{{-- PENDING: APPROVE AND REJECT --}}

{{-- PENDING: APPROVE AND REJECT --}}
@if($application->status === 'Pending')

    {{-- APPROVE APPLICATION --}}
    <form
        action="{{ route('admin.adoptions.approve', $application->id) }}"
        method="POST"
        class="inline-action-form"
        
    >
        @csrf
        @method('PATCH')

        <button
            type="submit"
            class="action-btn approve-btn"
        >
            <i class="bi bi-check-lg"></i>
            Approve
        </button>
    </form>

    {{-- REJECT APPLICATION --}}
    <button
        type="button"
        class="action-btn reject-btn"
        title="Reject Adoption Application"
        data-bs-toggle="modal"
        data-bs-target="#rejectAdoptionModal"
        data-reject-url="{{ route('admin.adoptions.reject', $application->id) }}"
        data-applicant-name="{{ $fullName }}"
    >
        <i class="bi bi-x-lg"></i>
        Reject
    </button>

{{-- APPROVED: COMPLETE --}}
@elseif($application->status === 'Approved')

    <form
        action="{{ route('admin.adoptions.complete', $application->id) }}"
        method="POST"
        class="inline-action-form"
    >
        @csrf
        @method('PATCH')

        <button
            type="submit"
            class="action-btn complete-btn"
        >
            <i class="bi bi-check2-circle"></i>
            Complete
        </button>
    </form>

{{-- REJECTED: ARCHIVE --}}
@elseif($application->status === 'Rejected')

    <form
        action="{{ route('admin.adoptions.archive', $application->id) }}"
        method="POST"
        class="inline-action-form"
    >
        @csrf

        <button
            type="submit"
            class="action-btn archive-btn"
            title="Move to Archive"
        >
            <i class="bi bi-archive-fill"></i>
            Archive
        </button>
    </form>

{{-- COMPLETED: DOWNLOAD --}}
@elseif($application->status === 'Completed')

    <a
        href="{{ route('admin.adoptions.download', $application->id) }}"
        class="action-btn download-btn"
        title="Download Adoption Application"
    >
        <i class="bi bi-download"></i>
        Download
    </a>

@endif

    </div>
</td>

                                   

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="empty-cell"
                                >

                                    <div class="empty-state">

                                        <i class="bi bi-inbox"></i>

                                        <strong>
                                            No adoption applications found.
                                        </strong>

                                        <span>
                                            No applications match this filter.
                                        </span>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =========================================================
                 PAGINATION
            ========================================================== --}}

            @if($applications->hasPages())

                <div class="pagination-area">

                    <div>

                        Showing

                        <strong>
                            {{ $applications->firstItem() ?? 0 }}
                        </strong>

                        to

                        <strong>
                            {{ $applications->lastItem() ?? 0 }}
                        </strong>

                        of

                        <strong>
                            {{ $applications->total() }}
                        </strong>

                        applications

                    </div>

                    <div>
                        {{ $applications->links() }}
                    </div>

                </div>

            @endif

        </section>

    </main>

</div>
{{-- =========================================================
     APPLICATION DETAILS MODAL
========================================================= --}}

<div
    class="application-modal"
    id="applicationDetailsModal"
    aria-hidden="true"
>

    {{-- BACKDROP --}}

    <div
        class="modal-backdrop-custom"
        data-close-modal
    ></div>


    <div
        class="application-modal-dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="applicationDetailsTitle"
    >

        {{-- HEADER --}}

        <div class="application-modal-header">

            <div>

                <span>
                    ADOPTION APPLICATION
                </span>

                <h2 id="applicationDetailsTitle">
                    Application Details
                </h2>

            </div>


            <button
                type="button"
                class="modal-close-btn"
                data-close-modal
                aria-label="Close"
            >

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        {{-- BODY --}}

        <div class="application-modal-body">

            {{-- APPLICANT --}}

            <section class="modal-section">

                <div class="modal-section-title">

                    <i class="bi bi-person-fill"></i>

                    <h3>
                        Applicant Information
                    </h3>

                </div>


                <div class="modal-info-grid">

                    <div class="info-item">

                        <span>Name</span>

                        <strong id="modalName">
                            —
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>Email</span>

                        <strong id="modalEmail">
                            —
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>Contact Number</span>

                        <strong id="modalContact">
                            —
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>Occupation</span>

                        <strong id="modalOccupation">
                            —
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>Civil Status</span>

                        <strong id="modalCivilStatus">
                            —
                        </strong>

                    </div>

                </div>

            </section>


            {{-- ANIMAL --}}

            <section class="modal-section">

                <div class="modal-section-title">

                    <i class="bi bi-heart-fill"></i>

                    <h3>
                        Animal Information
                    </h3>

                </div>


                <div class="modal-animal-layout">

                    <div class="modal-animal-image">

                        <img
                            id="modalAnimalImage"
                            src=""
                            alt="Animal"
                        >

                        <div
                            id="modalAnimalPlaceholder"
                            class="animal-image-placeholder"
                        >

                            <i class="bi bi-image"></i>

                        </div>

                    </div>


                    <div class="modal-animal-details">

                        <div class="info-item">

                            <span>Name</span>

                            <strong id="modalAnimalName">
                                —
                            </strong>

                        </div>


                        <div class="info-item">

                            <span>Type</span>

                            <strong id="modalAnimalType">
                                —
                            </strong>

                        </div>


                        <div class="info-item">

                            <span>Breed</span>

                            <strong id="modalAnimalBreed">
                                —
                            </strong>

                        </div>


                        <div class="info-item">

                            <span>Gender</span>

                            <strong id="modalAnimalGender">
                                —
                            </strong>

                        </div>


                        <div class="info-item">

                            <span>Age</span>

                            <strong id="modalAnimalAge">
                                —
                            </strong>

                        </div>


                        <div class="info-item">

                            <span>Status</span>

                            <strong id="modalAnimalStatus">
                                —
                            </strong>

                        </div>

                    </div>

                </div>

            </section>


            {{-- ADDRESS --}}

            <section class="modal-section">

                <div class="modal-section-title">

                    <i class="bi bi-geo-alt-fill"></i>

                    <h3>
                        Complete Address
                    </h3>

                </div>


                <div class="modal-info-grid">

                    <div class="info-item">

                        <span>
                            House / Unit / Street
                        </span>

                        <strong id="modalHouseStreet">
                            —
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>Region</span>

                        <strong id="modalRegion">
                            —
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>Province</span>

                        <strong id="modalProvince">
                            —
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>
                            City / Municipality
                        </span>

                        <strong id="modalCity">
                            —
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>Barangay</span>

                        <strong id="modalBarangay">
                            —
                        </strong>

                    </div>

                </div>

            </section>


            {{-- ADOPTION BACKGROUND --}}

            <section class="modal-section">

                <div class="modal-section-title">

                    <i class="bi bi-house-heart-fill"></i>

                    <h3>
                        Adoption Background
                    </h3>

                </div>


                <div class="modal-info-grid">

                    <div class="info-item full-width">

                        <span>
                            Reason for Adoption
                        </span>

                        <strong id="modalReason">
                            —
                        </strong>

                    </div>


                    <div class="info-item full-width">

                        <span>
                            Explanation
                        </span>

                        <strong id="modalReasonExplanation">
                            —
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>
                            Primary Responsible
                        </span>

                        <strong id="modalResponsible">
                            —
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>
                            Residence Type
                        </span>

                        <strong id="modalResidence">
                            —
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>
                            Household Members
                        </span>

                        <strong id="modalHouseholdMembers">
                            —
                        </strong>

                    </div>


                    <div class="info-item">

                        <span>
                            Household Support
                        </span>

                        <strong id="modalHouseholdSupport">
                            —
                        </strong>

                    </div>

                </div>

            </section>


            {{-- VALID ID --}}

            <section class="modal-section">

                <div class="modal-section-title">

                    <i class="bi bi-person-vcard-fill"></i>

                    <h3>
                        Valid ID
                    </h3>

                </div>


                <div class="valid-id-area">

                    <img
                        id="modalValidIdImage"
                        src=""
                        alt="Valid ID"
                    >


                    <div
                        id="modalValidIdPlaceholder"
                        class="valid-id-placeholder"
                    >

                        <i class="bi bi-card-image"></i>

                        <span>
                            Valid ID
                        </span>

                    </div>


                    <div class="valid-id-details">

                        <strong id="modalValidIdName">
                            Submitted Valid ID
                        </strong>


                        <a
                            href="#"
                            id="modalValidIdLink"
                            target="_blank"
                            rel="noopener noreferrer"
                        >

                            <i class="bi bi-box-arrow-up-right"></i>

                            View Full ID

                        </a>

                    </div>

                </div>

            </section>

        </div>


        {{-- FOOTER --}}

        <div class="application-modal-footer">

            <span>

                <i class="bi bi-info-circle"></i>

                Application Status:

                <strong id="modalApplicationStatus">
                    —
                </strong>

            </span>


            <button
                type="button"
                class="modal-footer-close"
                data-close-modal
            >
                Close
            </button>

        </div>

    </div>

</div>
{{-- =========================================================
     REJECT ADOPTION MODAL
========================================================= --}}
<div
    class="modal fade"
    id="rejectAdoptionModal"
    tabindex="-1"
    aria-labelledby="rejectAdoptionModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header">
                <h5 class="modal-title" id="rejectAdoptionModalLabel">
                    <i class="bi bi-x-circle-fill text-danger"></i>
                    Reject Adoption Application
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">

                <div class="alert alert-warning">
                    <strong>Are you sure you want to reject this application?</strong>
                    <p class="mb-0 mt-1">
                        <span id="rejectAdoptionApplicantName">Applicant</span>.
                        Please provide a reason for rejection.
                    </p>
                </div>

                <form
                    id="rejectAdoptionForm"
                    method="POST"
                    action="#"
                >
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label
                            for="adoption_rejection_reason_select"
                            class="form-label"
                        >
                            Reason for Rejection <span class="text-danger">*</span>
                        </label>

                        <select
                            id="adoption_rejection_reason_select"
                            class="form-select"
                            required
                        >
                            <option value="">Select a reason</option>

                            <option value="The adoption application is incomplete or missing required information.">
                                Incomplete application requirements
                            </option>

                            <option value="The submitted identification is invalid or insufficient for verification.">
                                Invalid or insufficient identification
                            </option>

                            <option value="The applicant does not meet the organization's adoption requirements.">
                                Does not meet adoption requirements
                            </option>

                            <option value="The applicant's living environment is not suitable for the animal's needs.">
                                Unsuitable living environment
                            </option>

                            <option value="The adoption team could not contact the applicant using the information provided.">
                                Unable to contact applicant
                            </option>

                            <option value="The applicant has not provided sufficient information to verify their suitability for adoption.">
                                Insufficient information for verification
                            </option>

                            <option value="other">Other reason</option>
                        </select>
                    </div>

                    {{-- CUSTOM REASON --}}
                    <div
                        class="mb-3"
                        id="customAdoptionReasonGroup"
                        style="display: none;"
                    >
                        <label
                            for="custom_adoption_rejection_reason"
                            class="form-label"
                        >
                            Enter your reason
                            <span class="text-danger">*</span>
                        </label>

                        <textarea
                            id="custom_adoption_rejection_reason"
                            class="form-control"
                            rows="4"
                            maxlength="500"
                            placeholder="Explain why this adoption application is being rejected..."
                        ></textarea>
                    </div>

                    {{-- VALUE SENT TO CONTROLLER --}}
                    <input
                        type="hidden"
                        id="adoption_rejection_reason"
                        name="rejection_reason"
                    >

                    <small class="text-muted">
                        Select the most appropriate reason or choose
                        "Other reason" to enter your own explanation.
                    </small>
                </form>
            </div>

            {{-- FOOTER --}}
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
                    form="rejectAdoptionForm"
                    class="btn btn-danger"
                >
                    <i class="bi bi-x-circle-fill"></i>
                    Confirm Reject
                </button>
            </div>

        </div>
    </div>
</div>


{{-- =========================================================
     MANAGE ADOPTIONS JAVASCRIPT
========================================================= --}}


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('js/manage-adoption.js') }}"></script>


</body>
</html>