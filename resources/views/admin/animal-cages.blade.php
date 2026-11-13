<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Cage Management | Animal Rescue PH</title>

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

    {{-- Cage Management CSS --}}
    <link
        rel="stylesheet"
        href="{{ asset('css/animal-cages.css') }}"
    >

</head>


<body>

<div class="cage-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <header class="cage-header">

        <div class="header-left">

            <a
                href="{{ route('admin.manage-animals') }}"
                class="back-button"
            >

                <i class="bi bi-arrow-left"></i>

                <span>
                    Back to Manage Animals
                </span>

            </a>


            <div class="header-title">

                <div class="header-icon">

                    <i class="bi bi-building"></i>

                </div>


                <div>

                    <h1>
                        Cage Management
                    </h1>

                    <p>
                        View and manage animal cages. Each cage can accommodate
                        up to 5 dogs or 5 cats.
                    </p>

                </div>

            </div>

        </div>


        <div class="header-actions">

            <button
                type="button"
                class="btn-add-cage"
                data-add-cage="{{ $type ?? 'Dog' }}"
            >

                <i class="bi bi-plus-lg"></i>

                Add Cage

            </button>

        </div>

    </header>



    {{-- =====================================================
         ALERTS
    ====================================================== --}}

    @if(session('success'))

        <div class="cage-alert success-alert">

            <i class="bi bi-check-circle-fill"></i>

            <span>
                {{ session('success') }}
            </span>

            <button
                type="button"
                class="alert-close"
                onclick="this.parentElement.remove()"
            >

                <i class="bi bi-x"></i>

            </button>

        </div>

    @endif


    @if(session('error'))

        <div class="cage-alert error-alert">

            <i class="bi bi-exclamation-circle-fill"></i>

            <span>
                {{ session('error') }}
            </span>

            <button
                type="button"
                class="alert-close"
                onclick="this.parentElement.remove()"
            >

                <i class="bi bi-x"></i>

            </button>

        </div>

    @endif


    @if($errors->any())

        <div class="cage-alert error-alert">

            <i class="bi bi-exclamation-triangle-fill"></i>

            <div>

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

            <button
                type="button"
                class="alert-close"
                onclick="this.parentElement.remove()"
            >

                <i class="bi bi-x"></i>

            </button>

        </div>

    @endif



    {{-- =====================================================
         SUMMARY CARDS
    ====================================================== --}}

    <section class="summary-grid">


        {{-- TOTAL CAGES --}}

        <div class="summary-card">

            <div class="summary-icon total">

                <i class="bi bi-building-fill"></i>

            </div>

            <div class="summary-content">

                <span>
                    Total Cages
                </span>

                <strong>
                    {{ $totalCages ?? 0 }}
                </strong>

                <small>
                    All animal cages
                </small>

            </div>

        </div>



        {{-- DOG CAGES --}}

        <div class="summary-card">

            <div class="summary-icon dog">

                <i class="bi bi-heart-fill"></i>

            </div>

            <div class="summary-content">

                <span>
                    Dog Cages
                </span>

                <strong>
                    {{ $dogCages ?? 0 }}
                </strong>

                <small>
                    {{ $dogOccupied ?? 0 }}
                    / {{ $dogTotalSlots ?? 0 }}
                    occupied
                </small>

            </div>

        </div>



        {{-- CAT CAGES --}}

        <div class="summary-card">

            <div class="summary-icon cat">

                <i class="bi bi-heart-fill"></i>

            </div>

            <div class="summary-content">

                <span>
                    Cat Cages
                </span>

                <strong>
                    {{ $catCages ?? 0 }}
                </strong>

                <small>
                    {{ $catOccupied ?? 0 }}
                    / {{ $catTotalSlots ?? 0 }}
                    occupied
                </small>

            </div>

        </div>



        {{-- AVAILABLE SLOTS --}}

        <div class="summary-card">

            <div class="summary-icon available">

                <i class="bi bi-grid-3x3-gap-fill"></i>

            </div>

            <div class="summary-content">

                <span>
                    Available Slots
                </span>

                <strong>

                    {{
                        ($dogAvailable ?? 0)
                        +
                        ($catAvailable ?? 0)
                    }}

                </strong>

                <small>
                    Spaces available
                </small>

            </div>

        </div>

    </section>



    {{-- =====================================================
         TOOLBAR
    ====================================================== --}}

    <section class="cage-toolbar">


        {{-- TABS --}}

        <div class="cage-tabs">

            <a
                href="{{ route('admin.cages', ['type' => 'dog']) }}"
                class="cage-tab
                {{ strtolower($type ?? 'dog') === 'dog' ? 'active' : '' }}"
                data-cage-type="Dog"
            >

                <i class="bi bi-heart-fill"></i>

                <span>
                    Dog Cages
                </span>

                <strong>
                    {{ $dogCages ?? 0 }}
                </strong>

            </a>


            <a
                href="{{ route('admin.cages', ['type' => 'cat']) }}"
                class="cage-tab
                {{ strtolower($type ?? 'dog') === 'cat' ? 'active' : '' }}"
                data-cage-type="Cat"
            >

                <i class="bi bi-heart-fill"></i>

                <span>
                    Cat Cages
                </span>

                <strong>
                    {{ $catCages ?? 0 }}
                </strong>

            </a>

        </div>



        {{-- STATUS LEGEND --}}

        <div class="status-legend">

            <span>
                <i class="legend-dot available"></i>
                Available
            </span>

            <span>
                <i class="legend-dot partial"></i>
                Partially Filled
            </span>

            <span>
                <i class="legend-dot full"></i>
                Full
            </span>

            <span>
                <i class="legend-dot maintenance"></i>
                Maintenance
            </span>

        </div>



        {{-- SEARCH --}}

        <form
            method="GET"
            action="{{ route('admin.cages') }}"
            class="cage-search-form"
        >

            <input
                type="hidden"
                name="type"
                value="{{ $type ?? 'dog' }}"
            >

            <div class="search-box">

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    id="cageSearch"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Search cage number..."
                >

            </div>

        </form>

    </section>



    {{-- =====================================================
         CAGE MANAGEMENT CONTENT
    ====================================================== --}}

    <section class="cage-management-layout">


        {{-- =================================================
             CAGE LIST
        ================================================== --}}

        <div class="cage-list-section">


            <div class="section-heading">

                <div>

                    <div class="section-title-row">

                        <span class="section-animal-icon">

                            <i class="bi bi-heart-fill"></i>

                        </span>

                        <h2>

                            {{ strtolower($type ?? 'dog') === 'dog'
                                ? 'Dog Cages'
                                : 'Cat Cages'
                            }}

                        </h2>

                    </div>


                    <p>
                        Each cage can accommodate up to 5
                        {{ strtolower($type ?? 'dog') === 'dog'
                            ? 'dogs'
                            : 'cats'
                        }}.
                    </p>

                </div>


                <span class="cage-count">

                    {{ $cages->total() }}

                    {{ $cages->total() == 1
                        ? 'Cage'
                        : 'Cages'
                    }}

                </span>

            </div>



            {{-- =================================================
                 CAGE GRID
            ================================================== --}}

            @if(isset($cages) && $cages->count())

                <div class="cage-grid">

                    @foreach($cages as $cage)

                        @php

                            $animals =
                                $cage->animals
                                ->take(5)
                                ->values();

                            $occupied =
                                $animals->count();

                            $capacity =
                                (int) $cage->capacity;

                            $available =
                                max(
                                    $capacity - $occupied,
                                    0
                                );

                            $displayStatus =
                                $cage->display_status;

                            $statusClass =
                                match($displayStatus) {

                                    'Available'
                                        => 'available',

                                    'Partially Filled'
                                        => 'partial',

                                    'Full'
                                        => 'full',

                                    'Maintenance'
                                        => 'maintenance',

                                    default
                                        => 'available',

                                };

                        @endphp



                        {{-- =================================================
                             CAGE CARD
                        ================================================== --}}

                        <article
                            class="cage-card {{ $statusClass }}"
                            data-cage-id="{{ $cage->id }}"
                        >


                            {{-- CAGE HEADER --}}

                            <div class="cage-card-header">

                                <div class="cage-number">

                                    <span>
                                        CAGE
                                    </span>

                                    <strong>
                                        {{ $cage->cage_number }}
                                    </strong>

                                </div>


                                <div class="cage-status">

                                    <span class="status-dot"></span>

                                    {{ $displayStatus }}

                                </div>

                            </div>



                            {{-- =================================================
                                 REAL CAGE HOUSE
                            ================================================== --}}

                            <div class="cage-house">


                                {{-- ROOF --}}

                                <div class="cage-roof">

                                    <div class="roof-left"></div>

                                    <div class="roof-right"></div>

                                    <div class="roof-top"></div>

                                </div>



                                {{-- CAGE BODY --}}

                                <div class="cage-body">


                                    {{-- CAGE NUMBER PLATE --}}

                                    <div class="cage-sign">

                                        {{ $cage->cage_number }}

                                    </div>



                                    {{-- BACK WALL --}}

                                    <div class="cage-back-wall"></div>



                                    {{-- VERTICAL BARS --}}

                                    <div class="cage-bars">

                                        @for($bar = 0; $bar < 9; $bar++)

                                            <span></span>

                                        @endfor

                                    </div>



                                    {{-- ANIMAL SLOTS --}}

                                    <div class="cage-slots">

                                        @for(
                                            $slot = 0;
                                            $slot < $capacity;
                                            $slot++
                                        )

                                            @php

                                                $animal =
                                                    $animals->get($slot);

                                            @endphp


                                            <div
                                                class="cage-slot
                                                {{ $animal ? 'occupied' : 'empty' }}"
                                            >

                                                @if($animal)

                                                    @if($animal->animal_image)

                                                        <img
                                                            src="{{ asset('uploads/animals/' . $animal->animal_image) }}"
                                                            alt="{{ $animal->name ?: 'Animal' }}"
                                                        >

                                                    @else

                                                        <div class="animal-placeholder">

                                                            <i class="bi bi-heart-fill"></i>

                                                        </div>

                                                    @endif

                                                @else

                                                    <div class="empty-slot-icon">

                                                        <i class="bi bi-plus-lg"></i>

                                                    </div>

                                                @endif

                                            </div>

                                        @endfor

                                    </div>


                                </div>


                                {{-- CAGE FLOOR --}}

                                <div class="cage-floor"></div>

                            </div>



                            {{-- =================================================
                                 ANIMAL NAMES
                            ================================================== --}}

                            <div class="animal-names">

                                @forelse($animals as $animal)

                                    <span>

                                        {{ $animal->name ?: 'Unnamed' }}

                                    </span>

                                @empty

                                    <span class="no-animal-text">
                                        No animals assigned
                                    </span>

                                @endforelse

                            </div>



                            {{-- =================================================
                                 OCCUPANCY
                            ================================================== --}}

                            <div class="occupancy-section">

                                <div class="occupancy-top">

                                    <span>
                                        Occupancy
                                    </span>

                                    <strong>
                                        {{ $occupied }}/{{ $capacity }}
                                    </strong>

                                </div>


                                <div class="occupancy-bar">

                                    <div
                                        class="occupancy-fill"
                                        @style([
                                            'width' => (($capacity > 0)
                                                ? (($occupied / $capacity) * 100)
                                                : 0) . '%'
                                        ])
                                    ></div>

                                </div>

                            </div>



                            {{-- =================================================
                                 EMPTY SLOTS
                            ================================================== --}}

                            @if($available > 0)

                                <div class="empty-slot-row">

                                    @for(
                                        $slot = 0;
                                        $slot < $available;
                                        $slot++
                                    )

                                        <span>

                                            <i class="bi bi-plus"></i>

                                        </span>

                                    @endfor

                                </div>

                            @endif



                            {{-- =================================================
                                 FOOTER
                            ================================================== --}}

                            <div class="cage-card-footer">

                                <span>

                                    <i class="bi bi-grid-3x3-gap"></i>

                                    {{ $available }}

                                    {{
                                        $available == 1
                                            ? 'empty slot'
                                            : 'empty slots'
                                    }}

                                </span>


                                <button
                                    type="button"
                                    class="view-cage-button"
                                    data-cage-id="{{ $cage->id }}"
                                >

                                    View

                                    <i class="bi bi-chevron-right"></i>

                                </button>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- =================================================
                     ⭐ PAGINATION — TAMANG LOKASYON
                ================================================== --}}

                @if($cages->hasPages())

                    <div class="cage-pagination-wrapper">

                        {{ $cages->onEachSide(1)->links('pagination::bootstrap-5') }}

                    </div>

                @endif


            @else

                {{-- =================================================
                     EMPTY STATE
                ================================================== --}}

                <div class="empty-state">

                    <div class="empty-cage-house">

                        <div class="empty-house-roof"></div>

                        <div class="empty-house-body">

                            <div class="empty-house-bars">

                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>

                            </div>

                            <i class="bi bi-heart-fill"></i>

                        </div>

                    </div>


                    <h3>

                        No
                        {{ strtolower($type ?? 'dog') }}
                        cages found

                    </h3>


                    <p>

                        @if(!empty($search))

                            No cages match your search.

                        @else

                            There are currently no
                            {{ strtolower($type ?? 'dog') }}
                            cages registered.

                        @endif

                    </p>


                    <button
                        type="button"
                        class="btn-add-cage"
                        data-add-cage="{{ $type ?? 'Dog' }}"
                    >

                        <i class="bi bi-plus-lg"></i>

                        Add
                        {{ $type ?? 'Dog' }}
                        Cage

                    </button>

                </div>

            @endif

        </div>
        {{-- /.cage-list-section --}}

    </section>
    {{-- /.cage-management-layout --}}

</div>
{{-- /.cage-page --}}



{{-- =========================================================
     ADD CAGE MODAL
========================================================= --}}

<div
    class="modal fade"
    id="addCageModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content cage-modal">

            <div class="modal-header">

                <div class="modal-heading">

                    <span class="modal-icon">

                        <i class="bi bi-building-add"></i>

                    </span>

                    <div>

                        <h5>
                            Add New Cage
                        </h5>

                        <p>
                            Create a new animal cage.
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                method="POST"
                action="{{ route('admin.cages.store') }}"
            >

                @csrf

                <div class="modal-body">


                    <div class="mb-3">

                        <label>
                            Cage Number
                        </label>

                        <input
                            type="text"
                            name="cage_number"
                            class="form-control"
                            placeholder="Example: D-001"
                            maxlength="50"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label>
                            Animal Type
                        </label>

                        <select
                            name="animal_type"
                            id="newCageAnimalType"
                            class="form-select"
                            required
                        >

                            <option value="Dog">
                                Dog
                            </option>

                            <option value="Cat">
                                Cat
                            </option>

                        </select>

                    </div>


                    <div class="mb-3">

                        <label>
                            Capacity
                        </label>

                        <input
                            type="number"
                            name="capacity"
                            class="form-control"
                            value="5"
                            min="1"
                            max="5"
                            required
                        >

                        <small>
                            Maximum capacity is 5 animals per cage.
                        </small>

                    </div>


                    <div class="mb-3">

                        <label>
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select"
                            required
                        >

                            <option value="Available">
                                Available
                            </option>

                            <option value="Maintenance">
                                Maintenance
                            </option>

                        </select>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn-modal-cancel"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn-modal-save"
                    >

                        <i class="bi bi-check-lg"></i>

                        Save Cage

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- =========================================================
     EDIT CAGE MODAL
========================================================= --}}

<div
    class="modal fade"
    id="editCageModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content cage-modal">

            <div class="modal-header">

                <div class="modal-heading">

                    <span class="modal-icon">

                        <i class="bi bi-pencil-square"></i>

                    </span>

                    <div>

                        <h5>
                            Edit Cage
                        </h5>

                        <p>
                            Update cage information.
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                method="POST"
                id="editCageForm"
            >

                @csrf

                @method('PUT')


                <input
                    type="hidden"
                    name="cage_id"
                    id="editCageId"
                >


                <div class="modal-body">

                    <div class="mb-3">

                        <label>
                            Cage Number
                        </label>

                        <input
                            type="text"
                            name="cage_number"
                            id="editCageNumber"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label>
                            Animal Type
                        </label>

                        <select
                            name="animal_type"
                            id="editCageAnimalType"
                            class="form-select"
                            required
                        >

                            <option value="Dog">
                                Dog
                            </option>

                            <option value="Cat">
                                Cat
                            </option>

                        </select>

                    </div>


                    <div class="mb-3">

                        <label>
                            Capacity
                        </label>

                        <input
                            type="number"
                            name="capacity"
                            id="editCageCapacity"
                            class="form-control"
                            min="1"
                            max="5"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label>
                            Status
                        </label>

                        <select
                            name="status"
                            id="editCageStatus"
                            class="form-select"
                            required
                        >

                            <option value="Available">
                                Available
                            </option>

                            <option value="Maintenance">
                                Maintenance
                            </option>

                        </select>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn-modal-cancel"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn-modal-save"
                    >

                        <i class="bi bi-check-lg"></i>

                        Save Changes

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- =========================================================
     VIEW CAGE MODAL
========================================================= --}}

<div
    class="modal fade"
    id="viewCageModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content cage-view-modal">

            <div class="modal-header cage-modal-header">

                <div>

                    <span class="cage-modal-label">
                        CAGE DETAILS
                    </span>

                    <h5
                        class="modal-title"
                        id="cageModalTitle"
                    >
                        Cage
                    </h5>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>

            <div
                class="modal-body"
                id="cageModalBody"
            >
                {{-- Content will be injected by JS --}}
            </div>

            <div class="modal-footer cage-modal-footer">

                <button
                    type="button"
                    class="btn-modal-close"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>

                <button
                    type="button"
                    class="btn-modal-edit"
                    id="modalEditCageBtn"
                >
                    <i class="bi bi-pencil-fill"></i>
                    Edit Cage
                </button>

            </div>

        </div>

    </div>

</div>



{{-- Bootstrap JS --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


{{-- Cage Management JS --}}

<script
    src="{{ asset('js/animal-cages.js') }}"
></script>


</body>

</html>