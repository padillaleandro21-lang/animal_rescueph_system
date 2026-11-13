<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Registered Dogs | Animal Rescue PH</title>

    {{-- Bootstrap 5 --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
   {{-- Font Awesome --}}
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
>
    {{-- Registered Dogs CSS --}}
    <link
        rel="stylesheet"
        href="{{ asset('css/registered-dogs.css') }}"
    >

</head>

<body>

<div class="registered-dogs-page">

    {{-- =========================================================
         BACK LINK
    ========================================================== --}}
    <div class="page-container">

    <a
        href="{{ route('admin.manage-animals') }}"
        class="back-link"
    >
        <i class="bi bi-arrow-left"></i>
        Back to Manage Animals
    </a>

</div>


    {{-- =========================================================
         HERO
    ========================================================== --}}
    <section class="hero-section page-container">

        <div class="hero-content">

            <span class="hero-label">
                REGISTERED DOGS
            </span>

            <h1>
                Registered Dogs
            </h1>

            <p>
                View and manage all registered dogs in the system.
            </p>

        </div>

        <div class="hero-decoration">

            <i class="bi bi-heart-fill paw paw-one"></i>
            <i class="bi bi-paw-fill paw paw-two"></i>
            <i class="bi bi-paw-fill paw paw-three"></i>

           <div class="dog-circle">
    <i class="fa-solid fa-dog"></i>
</div>

        </div>

    </section>


    {{-- =========================================================
         FILTERS
    ========================================================== --}}
    <section class="filter-card page-container">

        <form
            method="GET"
            action="{{ route('admin.registered-dogs') }}"
            class="filter-form"
        >

            {{-- BREED --}}
            <div class="filter-group">

                <label for="breed">
                    Breed Type
                </label>

                <div class="select-wrapper">

                    <i class="bi bi-paw-fill"></i>

                    <select
                        name="breed"
                        id="breed"
                        class="form-select"
                    >

                        <option value="">
                            All Breed Types
                        </option>

                        @foreach($breeds as $breed)

                            <option
                                value="{{ $breed }}"
                                {{ request('breed') === $breed ? 'selected' : '' }}
                            >
                                {{ $breed }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>


            {{-- STATUS --}}
            <div class="filter-group">

                <label for="status">
                    Status
                </label>

                <div class="select-wrapper">

                    <i class="bi bi-list-ul"></i>

                    <select
                        name="status"
                        id="status"
                        class="form-select"
                    >

                        <option value="">
                            All Status
                        </option>

                        @foreach($statuses as $status)

                            <option
                                value="{{ $status }}"
                                {{ request('status') === $status ? 'selected' : '' }}
                            >
                                {{ $status }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>


            {{-- SEARCH --}}
            <div class="filter-group search-group">

                <label for="search">
                    Search
                </label>

                <div class="search-wrapper">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Search by name, breed, or ID..."
                        autocomplete="off"
                    >

                </div>

            </div>


            {{-- FILTER BUTTON --}}
            <div class="filter-button-wrapper">

                <button
                    type="submit"
                    class="btn-filter"
                >

                    <i class="bi bi-funnel-fill"></i>

                    Filter

                </button>

            </div>


            {{-- REGISTER ANIMAL --}}
            <div class="register-button-wrapper">
<a 
    href="{{ route('admin.register-animal', ['from' => url()->full()]) }}" 
    class="btn-register"
>
    <i class="bi bi-plus-lg"></i>
    Register Animal
</a>
            </div>

        </form>


        {{-- =====================================================
             ACTIVE FILTERS
        ====================================================== --}}

        @if(
            request()->filled('breed') ||
            request()->filled('status') ||
            request()->filled('search')
        )

            <div class="active-filters">

                <span class="active-filter-title">
                    Active Filters:
                </span>


                @if(request()->filled('breed'))

                    <span class="filter-tag">
                        Breed:
                        {{ request('breed') }}
                    </span>

                @endif


                @if(request()->filled('status'))

                    <span class="filter-tag">
                        Status:
                        {{ request('status') }}
                    </span>

                @endif


                @if(request()->filled('search'))

                    <span class="filter-tag">
                        Search:
                        {{ request('search') }}
                    </span>

                @endif


                <a
                    href="{{ route('admin.registered-dogs') }}"
                    class="clear-filters"
                >

                    <i class="bi bi-x-circle"></i>

                    Clear Filters

                </a>

            </div>

        @endif

    </section>


    {{-- =========================================================
         DOG AGE DISTRIBUTION
    ========================================================== --}}
    <section class="age-chart-card page-container">

        <div class="chart-header">

            <div>

                <span class="chart-label">
                    Age chart
                </span>

                <h2>
                    Registered Dog Age 
                </h2>

                <p>
                    Shows active registered dogs by age category.
                  
                </p>

            </div>


            <div class="chart-icon">

                <i class="bi bi-bar-chart-fill"></i>

            </div>

        </div>


        <div class="chart-container">

            <canvas
                id="dogAgeChart"
                data-young="{{ $ageCounts['young'] ?? 0 }}"
                data-adult="{{ $ageCounts['adult'] ?? 0 }}"
                data-old="{{ $ageCounts['old'] ?? 0 }}"
            ></canvas>

        </div>

    </section>


    {{-- =========================================================
         SUCCESS MESSAGE
    ========================================================== --}}
    @if(session('success'))

        <div class="page-container">

            <div class="success-message">

                <i class="bi bi-check-circle-fill"></i>

                {{ session('success') }}

            </div>

        </div>

    @endif


    {{-- =========================================================
         TABLE
    ========================================================== --}}
    <section class="table-card page-container">

        <div class="table-responsive">

            <table class="dogs-table">

                <thead>

                    <tr>

                      
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Date Registered</th>
                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($dogs as $dog)

                        <tr>

                            {{-- ID --}}
                         


                            {{-- PHOTO --}}
                            <td>

                                @if($dog->animal_image)

                                    <img
                                        src="{{ asset('uploads/animals/' . $dog->animal_image) }}"
                                        alt="{{ $dog->name }}"
                                        class="dog-photo"
                                    >

                                @else

                                    <div class="dog-photo-placeholder">

                                        <i class="bi bi-image"></i>

                                    </div>

                                @endif

                            </td>


                            {{-- NAME --}}
                            <td>

                                <strong class="dog-name">
                                    {{ $dog->name }}
                                </strong>

                            </td>


                            {{-- BREED --}}
                            <td>
                                {{ $dog->breed ?: '—' }}
                            </td>


                            {{-- AGE --}}
                           <td>
    @php
        $displayAge = $dog->age
            ? str_ireplace(' years', '', trim($dog->age))
            : null;
    @endphp

    {{ $displayAge ?: '—' }}
</td>

                            {{-- GENDER --}}
                            <td>

                                <span class="gender-value">

                                    @if(strtolower($dog->gender ?? '') === 'male')

                                        <i class="bi bi-gender-male"></i>

                                    @elseif(strtolower($dog->gender ?? '') === 'female')

                                        <i class="bi bi-gender-female"></i>

                                    @endif

                                    {{ $dog->gender ?: '—' }}

                                </span>

                            </td>


                            {{-- STATUS --}}
                            <td>

                                @php
                                    $statusClass = match($dog->status) {
                                        'For Adoption' => 'status-adoption',
                                        'Under Treatment' => 'status-treatment',
                                        'Adopted' => 'status-adopted',
                                        default => 'status-default',
                                    };
                                @endphp

                                <span class="status-badge {{ $statusClass }}">

                                    <span class="status-dot"></span>

                                    {{ $dog->status ?: 'Registered' }}

                                </span>

                            </td>


                            {{-- DATE --}}
                            <td>

                                {{ optional($dog->date_acquired)->format('M d, Y') }}

                            </td>


                            {{-- ACTIONS --}}
                            <td>

                                <div class="action-buttons">

                                    {{-- VIEW --}}
                                    <button
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewDogModal"
                                        data-id="{{ $dog->id }}"
                                        data-name="{{ $dog->name }}"
                                        data-type="{{ $dog->animal_type }}"
                                        data-breed="{{ $dog->breed }}"
                                        data-age="{{ $dog->age }}"
                                        data-gender="{{ $dog->gender }}"
                                        data-weight="{{ $dog->weight }}"
                                        data-height="{{ $dog->height }}"
                                        data-status="{{ $dog->status }}"
                                        data-cage="{{ $dog->cage?->cage_number }}"
                                        data-date-acquired="{{ $dog->date_acquired?->format('Y-m-d') }}"
                                        data-health="{{ $dog->health_condition }}"
                                        data-medical="{{ $dog->medical_notes }}"
                                        data-notes="{{ $dog->additional_notes }}"
                                        data-image="{{ $dog->animal_image ? asset('uploads/animals/' . $dog->animal_image) : '' }}"
                                       data-vaccinations='{{ json_encode($dog->vaccinations ?? []) }}'
                                    >

                                        <i class="bi bi-eye-fill"></i>

                                        View

                                    </button>


                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('admin.registered-dogs.edit', $dog->id) }}"
                                        class="btn-edit"
                                    >

                                        <i class="bi bi-pencil-fill"></i>

                                        Edit

                                    </a>
                                          <a
        href="{{ route('admin.registered-animal.export', $dog->id) }}"
        class="btn-download"
        title="Download Report"
    >
        <i class="bi bi-download"></i>
        Download
    </a>

                                    {{-- ACTION MENU --}}
                                    <div
                                        id="action-menu-{{ $dog->id }}"
                                        class="action-menu"
                                    >

                                        {{-- VIEW DETAILS --}}
                                        <button
                                            type="button"
                                            class="action-menu-view"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewDogModal"
                                            data-id="{{ $dog->id }}"
                                            data-name="{{ $dog->name }}"
                                            data-type="{{ $dog->animal_type }}"
                                            data-breed="{{ $dog->breed }}"
                                            data-age="{{ $dog->age }}"
                                            data-gender="{{ $dog->gender }}"
                                            data-weight="{{ $dog->weight }}"
                                            data-height="{{ $dog->height }}"
                                            data-status="{{ $dog->status }}"
                                            data-cage="{{ $dog->cage?->cage_number }}"
                                            data-date-acquired="{{ $dog->date_acquired?->format('Y-m-d') }}"
                                            data-source="{{ $dog->source_type }}"
                                            data-location="{{ $dog->location_found }}"
                                            data-health="{{ $dog->health_condition }}"
                                            data-medical="{{ $dog->medical_notes ?? '' }}"
                                            data-notes="{{ $dog->additional_notes }}"
                                            data-image="{{ $dog->animal_image ? asset('uploads/animals/' . $dog->animal_image) : '' }}"
                                           data-vaccinations='{{ json_encode($dog->vaccinations ?? []) }}'
                                        >

                                            <i class="bi bi-eye"></i>

                                            View Details

                                        </button>


                                        {{-- EDIT INFORMATION --}}
                                        <a
                                            href="{{ route('admin.registered-dogs.edit', $dog->id) }}"
                                            class="action-menu-edit"
                                        >

                                            <i class="bi bi-pencil"></i>

                                            Edit Information

                                        </a>

                                    </div>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="empty-state"
                            >

                                <i class="bi bi-search"></i>

                                <h4>
                                    No registered dogs found
                                </h4>

                                <p>
                                    Try changing your filters or search term.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
             TABLE FOOTER
        ====================================================== --}}
        <div class="table-footer">

            <div class="result-count">

                Showing
                {{ $dogs->firstItem() ?? 0 }}
                to
                {{ $dogs->lastItem() ?? 0 }}
                of
                {{ $dogs->total() }}
                dogs

            </div>


            @if($dogs->hasPages())

                <div class="pagination-wrapper">

                    {{ $dogs->onEachSide(1)->links('pagination::bootstrap-5') }}

                </div>

            @endif

        </div>

    </section>

</div>


{{-- =====================================================
     VIEW REGISTERED DOG MODAL
====================================================== --}}

<div
    class="modal fade"
    id="viewDogModal"
    tabindex="-1"
    aria-labelledby="viewDogModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content dog-view-modal">


            {{-- HEADER --}}
            <div class="modal-header dog-modal-header">

                <div>

                    <span class="dog-modal-label">
                        REGISTERED DOG
                    </span>

                    <h5
                        class="modal-title"
                        id="viewDogModalLabel"
                    >
                        Dog Details
                    </h5>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            {{-- BODY --}}
            <div class="modal-body">

                <div class="dog-modal-grid">


                    {{-- PHOTO --}}
                    <div class="dog-modal-photo-section">

                        <div class="dog-modal-photo-wrapper">

                            <img
                                id="modalDogImage"
                                src=""
                                alt="Dog"
                                class="dog-modal-photo"
                            >

                            <div
                                id="modalDogImagePlaceholder"
                                class="dog-modal-photo-placeholder"
                            >

                                <i class="bi bi-image"></i>

                            </div>

                        </div>

                    </div>


                    {{-- BASIC INFORMATION --}}
                    <div class="dog-modal-information">

                        <div class="dog-modal-name-row">

                            <div>

                                <span class="dog-modal-small-label">
                                    ANIMAL NAME
                                </span>

                                <h3 id="modalDogName">
                                    —
                                </h3>

                            </div>


                            <span
                                id="modalDogStatus"
                                class="status-badge status-default"
                            >

                                <span class="status-dot"></span>

                                —

                            </span>

                        </div>


                        <div class="dog-modal-info-grid">


                            {{-- ID --}}
                            <div class="dog-detail-item">

                                <span class="dog-detail-label">
                                    Animal ID
                                </span>

                                <strong id="modalDogId">
                                    —
                                </strong>

                            </div>


                            {{-- TYPE --}}
                            <div class="dog-detail-item">

                                <span class="dog-detail-label">
                                    Animal Type
                                </span>

                                <strong id="modalDogType">
                                    —
                                </strong>

                            </div>


                            {{-- BREED --}}
                            <div class="dog-detail-item">

                                <span class="dog-detail-label">
                                    Breed
                                </span>

                                <strong id="modalDogBreed">
                                    —
                                </strong>

                            </div>


                            {{-- AGE --}}
                            <div class="dog-detail-item">

                                <span class="dog-detail-label">
                                    Age
                                </span>

                                <strong id="modalDogAge">
                                    —
                                </strong>

                            </div>


                            {{-- GENDER --}}
                            <div class="dog-detail-item">

                                <span class="dog-detail-label">
                                    Gender
                                </span>

                                <strong id="modalDogGender">
                                    —
                                </strong>

                            </div>


                            {{-- WEIGHT --}}
                            <div class="dog-detail-item">

                                <span class="dog-detail-label">
                                    Weight
                                </span>

                                <strong id="modalDogWeight">
                                    —
                                </strong>

                            </div>


                            {{-- HEIGHT --}}
                            <div class="dog-detail-item">

                                <span class="dog-detail-label">
                                    Height
                                </span>

                                <strong id="modalDogHeight">
                                    —
                                </strong>

                            </div>


                            {{-- CAGE --}}
                            <div class="dog-detail-item">

                                <span class="dog-detail-label">
                                    Cage
                                </span>

                                <strong id="modalDogCage">
                                    —
                                </strong>

                            </div>


                            {{-- DATE --}}
                            <div class="dog-detail-item">

                                <span class="dog-detail-label">
                                    Date Acquired
                                </span>

                                <strong id="modalDogDate">
                                    —
                                </strong>

                            </div>
    </div>

                    </div>

                </div>

                            {{-- SOURCE --}}
                           


                {{-- HEALTH --}}
                <div class="dog-modal-section">

                    <div class="dog-modal-section-title">

                        <i class="bi bi-heart-pulse-fill"></i>

                        Health Information

                    </div>


                    <div class="dog-modal-info-grid">

                        <div class="dog-detail-item">

                            <span class="dog-detail-label">
                                Health Condition
                            </span>

                            <strong id="modalDogHealth">
                                —
                            </strong>

                        </div>


                        <div class="dog-detail-item">

                            <span class="dog-detail-label">
                                Medical Notes
                            </span>

                            <strong id="modalDogMedical">
                                —
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- VACCINATIONS --}}
                <div class="dog-modal-section">

                    <div class="dog-modal-section-title">

                        <i class="bi bi-shield-check"></i>

                        Vaccination / Medical Records

                    </div>


                    <div
                        id="modalDogVaccinations"
                        class="dog-vaccination-list"
                    >

                        <span class="dog-empty-record">
                            No vaccination records.
                        </span>

                    </div>

                </div>


                {{-- ADDITIONAL NOTES --}}
                <div class="dog-modal-section">

                    <div class="dog-modal-section-title">

                        <i class="bi bi-journal-text"></i>

                        Additional Notes

                    </div>

                    <p id="modalDogNotes">
                        —
                    </p>

                </div>


            </div>


            {{-- FOOTER --}}
            <div class="modal-footer dog-modal-footer">

                <button
                    type="button"
                    class="btn-modal-close"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>


                {{-- EDIT NOW USES THE SAME REGISTER ANIMAL PAGE --}}
           <a 
    href="#" 
    id="modalDogEditButton" 
    class="btn-modal-edit" 
>
    <i class="bi bi-pencil-fill"></i>
    Edit Dog
</a>
                

            </div>


        </div>

    </div>

</div>


{{-- =====================================================
     SCRIPTS
====================================================== --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

<script
    src="https://cdn.jsdelivr.net/npm/chart.js"
></script>

<script
    src="{{ asset('js/registered-dogs.js') }}"
></script>

</body>
</html>
