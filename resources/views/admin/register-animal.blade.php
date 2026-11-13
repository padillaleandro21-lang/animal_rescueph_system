<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ ($editMode ?? false) ? 'Edit Animal' : 'Register Animal' }} | Animal Rescue PH
    </title>

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

    {{-- Custom CSS --}}
    <link
        rel="stylesheet"
        href="{{ asset('css/register-animal.css') }}?v={{ time() }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('css/admin-dashboard.css') }}"
    >

</head>

<body data-edit-mode="{{ ($editMode ?? false) ? 'true' : 'false' }}">

<div class="register-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <header class="register-header">

        <div class="brand-area">

            <div class="brand-icon">
                <i class="bi bi-file-earmark-medical-fill"></i>
            </div>

            <div>
                <strong>
                    {{ ($editMode ?? false) ? 'Edit Animal' : 'Register Animal' }}
                </strong>

                <div class="breadcrumb-line">
                    <span>Manage Animals</span>
                    <i class="bi bi-chevron-right"></i>
                    <strong>
                        {{ ($editMode ?? false) ? 'Edit Animal' : 'Register Animal' }}
                    </strong>
                </div>
            </div>

        </div>

        <div class="header-right">


             
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


    {{-- =====================================================
         PAGE TOOLBAR
    ====================================================== --}}

    <div class="page-toolbar">

        <a
            href="{{ request('from') === 'manage-animals'
                ? route('admin.manage-animals')
                : (
                    ($editMode ?? false)
                        ? (
                            strtolower(trim($animal->animal_type ?? '')) === 'cat'
                                ? route('admin.registered-cats')
                                : route('admin.registered-dogs')
                        )
                        : request('from', route('admin.manage-animals'))
                )
            }}"
            class="back-button"
        >
            <i class="bi bi-arrow-left"></i>

            {{ request('from') === 'manage-animals'
                ? 'Back to Manage Animals'
                : (
                    ($editMode ?? false)
                        ? (
                            strtolower(trim($animal->animal_type ?? '')) === 'cat'
                                ? 'Back to Registered Cats'
                                : 'Back to Registered Dogs'
                        )
                        : 'Back to Previous Page'
                )
            }}
        </a>

    </div>


    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

    <main class="register-container">

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())

            <div class="custom-alert error-alert">

                <i class="bi bi-exclamation-triangle-fill"></i>

                <div>

                    <strong>Please check the following:</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            </div>

        @endif


        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="custom-alert success-alert">

                <i class="bi bi-check-circle-fill"></i>

                <span>{{ session('success') }}</span>

            </div>

        @endif


        {{-- =====================================================
             FORM
        ====================================================== --}}

        <form
            action="{{ ($editMode ?? false)
                ? route('admin.registered-dogs.update', $animal->id)
                : route('admin.register-animal.store') }}"
            method="POST"
            enctype="multipart/form-data"
            id="registerAnimalForm"
        >
      @if(!empty($selectedReportId))
    <input
        type="hidden"
        id="report_id"
        name="report_id"
        value="{{ $selectedReportId }}"
    >
@endif

            @csrf

            @if($editMode ?? false)
                @method('PUT')
            @endif


            {{-- =================================================
                 TWO COLUMN STRUCTURE
            ================================================== --}}

            <div class="form-layout">


                {{-- =================================================
                     LEFT COLUMN
                ================================================== --}}

                <div class="left-column">


                    {{-- =============================================
                         1. BASIC INFORMATION
                    ============================================== --}}

                    <section class="form-card">

                        <div class="section-title-row">

                            <div class="section-title">

                                <span class="section-icon">
                                    <i class="bi bi-file-earmark-text-fill"></i>
                                </span>

                                <div>
                                    <h2>Basic Information</h2>
                                </div>

                            </div>

                        </div>


                        <div class="basic-grid">


                            {{-- ANIMAL NAME --}}

                            <div class="full-field">

                                <label class="form-label">
                                    Animal Name <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    value="{{ old('name', $animal->name ?? '') }}"
                                    placeholder="Enter animal name"
                                    required
                                >

                            </div>


                            {{-- ANIMAL TYPE --}}

                            <div>

                                <label class="form-label">
                                    Animal Type <span>*</span>
                                </label>

                                <select
                                    name="animal_type"
                                    id="animal_type"
                                    class="form-select"
                                    required
                                >

                                    <option value="" disabled
                                     {{ old('animal_type', $animal->animal_type ?? $selectedReport?->animal_type ?? '') === '' ? 'selected' : '' }}>
                                        Select Animal Type
                                    </option>

                                    <option
                                        value="Dog"
                                        {{ old('animal_type', $animal->animal_type ?? $selectedReport?->animal_type ?? '') === 'Dog' ? 'selected' : '' }}
                                    >
                                        Dog
                                    </option>

                                    <option
                                        value="Cat"
                                         {{ old('animal_type', $animal->animal_type ?? $selectedReport?->animal_type ?? '') === 'Cat' ? 'selected' : '' }}
                                    >
                                        Cat
                                    </option>

                                </select>

                            </div>


                            {{-- BREED --}}

          <div>

    <label class="form-label">
        Breed <span>*</span>
    </label>

    <select
    name="breed"
    id="breed"
    class="form-control"
    data-selected-breed="{{ old('breed', $animal->breed ?? $selectedReport?->breed ?? '') }}"
    required
>
    <option value="">Select Breed</option>
</select>

</div>

                            {{-- AGE --}}

                            <div>

                                <label class="form-label">
                                    Age <span>*</span>
                                </label>

                                @php
                                    $currentAge = old('age', $animal->age ?? '');
                                    $currentAge = str_ireplace(' years', '', trim($currentAge));
                                @endphp

                                <select
                                    name="age"
                                    class="form-select"
                                    required
                                >

                                    <option value="" disabled
                                        {{ $currentAge === '' ? 'selected' : '' }}>
                                        Select Age
                                    </option>

                                    <option
                                        value="Young"
                                        {{ strtolower($currentAge) === 'young' ? 'selected' : '' }}
                                    >
                                        Young
                                    </option>

                                    <option
                                        value="Adult"
                                        {{ strtolower($currentAge) === 'adult' ? 'selected' : '' }}
                                    >
                                        Adult
                                    </option>

                                    <option
                                        value="Old"
                                        {{ strtolower($currentAge) === 'old' ? 'selected' : '' }}
                                    >
                                        Old
                                    </option>

                                </select>

                            </div>


                            {{-- GENDER --}}

                            <div>

                                <label class="form-label">
                                    Gender <span>*</span>
                                </label>

                                <select
                                    name="gender"
                                    class="form-select"
                                    required
                                >

                                    <option value="" disabled
                                        {{ old('gender', $animal->gender ?? '') === '' ? 'selected' : '' }}>
                                        Select Gender
                                    </option>

                                    <option
                                        value="Male"
                                        {{ old('gender', $animal->gender ?? '') === 'Male' ? 'selected' : '' }}
                                    >
                                        Male
                                    </option>

                                    <option
                                        value="Female"
                                        {{ old('gender', $animal->gender ?? '') === 'Female' ? 'selected' : '' }}
                                    >
                                        Female
                                    </option>

                                </select>

                            </div>


                            {{-- WEIGHT --}}

                            <div>

                                <label class="form-label">
                                    Weight (kg)
                                </label>

                                <input
                                    type="number"
                                    name="weight"
                                    step="0.01"
                                    min="0"
                                    class="form-control"
                                    value="{{ old('weight', $animal->weight ?? '') }}"
                                    placeholder="0.00"
                                >

                            </div>


                            {{-- HEIGHT --}}

                            <div>

                                <label class="form-label">
                                    Height (cm)
                                </label>

                                <input
                                    type="number"
                                    name="height"
                                    step="0.01"
                                    min="0"
                                    class="form-control"
                                    value="{{ old('height', $animal->height ?? '') }}"
                                    placeholder="0.00"
                                >

                            </div>


                        </div>

                    </section>


                    {{-- =============================================
                         2. HEALTH INFORMATION
                    ============================================== --}}

                    <section class="form-card">

                        <div class="section-title-row">

                            <div class="section-title">

                                <span class="section-icon">
                                    <i class="bi bi-heart-pulse-fill"></i>
                                </span>

                                <div>
                                    <h2>Health Information</h2>
                                </div>

                            </div>

                        </div>


                        <div class="health-grid">


                            {{-- HEALTH CONDITION --}}

                            <div>

                                <label class="form-label">
                                    Overall Health Condition <span>*</span>
                                </label>

                                <select
                                    name="health_condition"
                                    class="form-select"
                                    required
                                >

                                    <option value="" disabled
                                        {{ old('health_condition', $animal->health_condition ?? '') === '' ? 'selected' : '' }}>
                                        Select Health Condition
                                    </option>

                                    <option
                                        value="Healthy"
                                        {{ old('health_condition', $animal->health_condition ?? '') === 'Healthy' ? 'selected' : '' }}
                                    >
                                        Healthy
                                    </option>

                                    <option
                                        value="Under Treatment"
                                        {{ old('health_condition', $animal->health_condition ?? '') === 'Under Treatment' ? 'selected' : '' }}
                                    >
                                        Under Treatment
                                    </option>

                                    <option
                                        value="Needs Observation"
                                        {{ old('health_condition', $animal->health_condition ?? '') === 'Needs Observation' ? 'selected' : '' }}
                                    >
                                        Needs Observation
                                    </option>

                                    <option
                                        value="Critical"
                                        {{ old('health_condition', $animal->health_condition ?? '') === 'Critical' ? 'selected' : '' }}
                                    >
                                        Critical
                                    </option>

                                </select>

                            </div>


                            {{-- MEDICAL NOTES --}}

                            <div>

                                <label class="form-label">
                                    Medical Notes
                                </label>

                                <textarea
                                    name="medical_notes"
                                    class="form-control"
                                    rows="2"
                                    placeholder="Enter medical information..."
                                >{{ old('medical_notes', $animal->medical_notes ?? '') }}</textarea>

                            </div>


                        </div>

                    </section>


                </div>


                {{-- =================================================
                     RIGHT COLUMN
                ================================================== --}}

                <div class="right-column">


                    {{-- =============================================
                         ANIMAL PHOTO
                    ============================================== --}}

                    <section class="form-card photo-panel">

                        <div class="section-title-row">

                            <div class="section-title">

                                <span class="section-icon">
                                    <i class="bi bi-camera-fill"></i>
                                </span>

                                <div>
                                    <h2>Animal Photo</h2>
                                </div>

                            </div>

                        </div>


                        <div class="photo-grid">


                            {{-- UPLOAD --}}

                            <label
                                class="upload-area"
                                for="animal_image"
                            >

                                <i class="bi bi-cloud-arrow-up-fill"></i>

                                <strong>
                                    Upload Animal Photo
                                </strong>

                                <small>
                                    JPG, PNG (Max 5MB)
                                </small>

                                <input
                                    type="file"
                                    name="animal_image"
                                    id="animal_image"
                                    accept=".jpg,.jpeg,.png,.webp"
                                >

                            </label>


                            {{-- PREVIEW --}}

                           @php
    $existingPhoto =
        $animal->animal_image
        ?? $selectedReport?->animal_image
        ?? null;
@endphp

                            <div
                                class="photo-preview"
                                id="currentPhoto"
                                @if(empty($existingPhoto)) hidden @endif
                            >

                               <img
  
    id="reportPhoto"
    src="{{ !empty($existingPhoto)
        ? asset('uploads/animals/'.rawurlencode($existingPhoto))
        : '' }}"
    alt="Animal Photo"
>

                                <button
                                    type="button"
                                    id="removePhoto"
                                    class="delete-photo"
                                >
                                    <i class="bi bi-trash-fill"></i>
                                </button>

                            </div>


                        </div>

                    </section>


                    {{-- =============================================
                         CAGE ASSIGNMENT
                    ============================================== --}}

                    <section class="form-card">

                        <div class="section-title-row">

                            <div class="section-title">

                                <span class="section-icon">
                                    <i class="bi bi-house-fill"></i>
                                </span>

                                <div>
                                    <h2>Cage Assignment</h2>
                                </div>

                            </div>

                        </div>


                        <div class="cage-top">


                            {{-- CAGE ANIMAL TYPE --}}

                            <div>

                                <label class="form-label">
                                    Animal Type
                                </label>

                                <select
                                    id="cageAnimalType"
                                    class="form-select auto-field"
                                >

                                    <option value="" disabled
                                        {{ old('animal_type', $animal->animal_type ?? '') === '' ? 'selected' : '' }}>
                                        Select Animal Type
                                    </option>

                                    <option
                                        value="Dog"
                                        {{ old('animal_type', $animal->animal_type ?? '') === 'Dog' ? 'selected' : '' }}
                                    >
                                        Dog
                                    </option>

                                    <option
                                        value="Cat"
                                       {{ old('animal_type', $animal->animal_type ?? $selectedReport?->animal_type ?? '') === 'Cat' ? 'selected' : '' }}
                                    >
                                        Cat
                                    </option>

                                </select>

                            </div>


                            {{-- CAPACITY MESSAGE --}}

                            <div
                                class="capacity-message"
                                id="capacityMessage"
                            >

                                <i class="bi bi-info-circle-fill"></i>

                                <span>
                                    Select an animal type to view cage capacity.
                                </span>

                            </div>


                        </div>


                        {{-- CAGE SELECT --}}

                        <div class="cage-select-wrap">

                            <label class="form-label">
                                Select Cage <span>*</span>
                            </label>

                            <select
                                name="cage_id"
                                id="cage_id"
                                class="form-select"
                                required
                            >

                                <option value="" disabled
                                    {{ old('cage_id', $animal->cage_id ?? '') === '' ? 'selected' : '' }}>
                                    Select Cage
                                </option>

                                @foreach($cages as $cage)

                                    @php

                                        $occupied = $cage->animals_count ?? 0;

                                        $capacity = $cage->capacity ?? 5;

                                        if ($cage->status === 'Maintenance') {

                                            $displayStatus = 'Maintenance';

                                        } elseif ($occupied >= $capacity) {

                                            $displayStatus = 'Full';

                                        } elseif ($occupied > 0) {

                                            $displayStatus = 'Partially Filled';

                                        } else {

                                            $displayStatus = 'Available';

                                        }

                                    @endphp

                                    <option
                                        value="{{ $cage->id }}"
                                        data-number="{{ $cage->cage_number }}"
                                        data-type="{{ strtolower($cage->animal_type) }}"
                                        data-status="{{ $cage->status }}"
                                        data-occupied="{{ $occupied }}"
                                        data-capacity="{{ $capacity }}"
                                        data-available="{{ max($capacity - $occupied, 0) }}"

                                        @if(
                                            $cage->status === 'Maintenance' ||
                                            $occupied >= $capacity
                                        )
                                            disabled
                                        @endif

                                        {{ old('cage_id', $animal->cage_id ?? '') == $cage->id
                                            ? 'selected'
                                            : '' }}
                                    >

                                        {{ $cage->cage_number }}
                                        —
                                        {{ $occupied }}/{{ $capacity }}
                                        —
                                        {{ $displayStatus }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- CAGE DETAILS --}}

                        <div class="cage-details">

                            <div>

                                <span>Cage Number</span>

                                <strong id="selectedCageNumber">
                                    —
                                </strong>

                            </div>

                            <div>

                                <span>Occupied Slots</span>

                                <strong id="selectedCageOccupied">
                                    —
                                </strong>

                            </div>

                            <div>

                                <span>Available Slots</span>

                                <strong id="selectedCageAvailable">
                                    —
                                </strong>

                            </div>

                        </div>

                    </section>


                    {{-- =============================================
                         VACCINATION
                    ============================================== --}}

                    <section class="form-card vaccination-panel">

                        <div class="section-title-row">

                            <div class="section-title">

                                <span class="section-icon">
                                    <i class="bi bi-eyedropper"></i>
                                </span>

                                <div>
                                    <h2>
                                        Vaccination / Medical Records
                                    </h2>
                                </div>

                            </div>

                        </div>


                        @php

                            $vaccinationList = [

                                'distemper' => 'Distemper',

                                'parvovirus' => 'Parvovirus',

                                'rabies' => 'Rabies',

                                'fvrcp' => 'FVRCP (Cats)',

                                'deworming' => 'Deworming',

                                'anti_flea' => 'Anti-flea / Anti-tick',

                                'others' => 'Others',

                                'spay_neuter' => 'Spay / Neuter',

                            ];

                        @endphp


                        <div class="vaccination-grid">

                            @foreach($vaccinationList as $key => $label)

                                <div class="vaccination-item">

                                    <div class="vaccination-name">

                                        <input
                                            type="checkbox"
                                            class="form-check-input vaccination-check"
                                            name="vaccinations[{{ $key }}]"
                                            value="Given"
                                            id="{{ $key }}_check"
                                        >

                                        <label for="{{ $key }}_check">
                                            {{ $label }}
                                        </label>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </section>


                </div>

            </div>


            {{-- =================================================
                 BOTTOM SECTION
            ================================================== --}}

            <div class="bottom-layout">


                {{-- =============================================
                     STATUS
                ============================================== --}}

                <section class="form-card status-panel">

                    <div class="section-title-row">

                        <div class="section-title">

                            <span class="section-icon">
                                <i class="bi bi-flag-fill"></i>
                            </span>

                            <div>
                                <h2>Status</h2>
                            </div>

                        </div>

                    </div>


                    <label class="form-label">
                        Initial Status <span>*</span>
                    </label>


                    <select
                        name="status"
                        class="form-select"
                        required
                    >

                        <option
                            value=""
                            disabled
                            {{ old('status', $animal->status ?? '') === '' ? 'selected' : '' }}
                        >
                            Select Status
                        </option>


                        @if($editMode ?? false)

                            <option
                                value="For Adoption"
                                {{ old('status', $animal->status ?? '') === 'For Adoption'
                                    ? 'selected'
                                    : '' }}
                            >
                                For Adoption
                            </option>

                            <option
                                value="Under Treatment"
                                {{ old('status', $animal->status ?? '') === 'Under Treatment'
                                    ? 'selected'
                                    : '' }}
                            >
                                Under Treatment
                            </option>

                            <option
                                value="Adopted"
                                {{ old('status', $animal->status ?? '') === 'Adopted'
                                    ? 'selected'
                                    : '' }}
                            >
                                Adopted
                            </option>

                        @else

                            <option
                                value="For Adoption"
                                {{ old('status') === 'For Adoption'
                                    ? 'selected'
                                    : '' }}
                            >
                                For Adoption
                            </option>

                            <option
                                value="Under Treatment"
                                {{ old('status') === 'Under Treatment'
                                    ? 'selected'
                                    : '' }}
                            >
                                Under Treatment
                            </option>

                        @endif

                    </select>

                </section>


                {{-- =============================================
                     OTHER INFORMATION
                ============================================== --}}

                <section class="form-card additional-panel">

                    <div class="section-title-row">

                        <div class="section-title">

                            <span class="section-icon">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </span>

                            <div>
                                <h2>Other Information</h2>
                            </div>

                        </div>

                    </div>


                    <div class="additional-row">


                        <div class="additional-notes">

                            <label class="form-label">
                                Additional Notes
                            </label>

                            <textarea
                                name="additional_notes"
                                class="form-control"
                                rows="2"
                                placeholder="Enter additional notes (optional)..."
                            >{{ old('additional_notes', $animal->additional_notes ?? '') }}</textarea>

                        </div>


                        <div class="action-buttons">

                            <a
                                href="{{ ($editMode ?? false)
                                    ? route('admin.registered-dogs')
                                    : route('admin.manage-animals') }}"
                                class="cancel-button"
                            >
                                Cancel
                            </a>


                            <button
                                type="submit"
                                class="register-button"
                            >

                                <i class="bi {{ ($editMode ?? false)
                                    ? 'bi-save-fill'
                                    : 'bi-paw-fill' }}">
                                </i>

                                {{ ($editMode ?? false)
                                    ? 'Update Animal'
                                    : 'Register Animal' }}

                            </button>

                        </div>

                    </div>

                </section>


            </div>

        </form>

    </main>

</div>


{{-- =====================================================
     BOOTSTRAP
====================================================== --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


{{-- =====================================================
     REGISTER ANIMAL JAVASCRIPT
====================================================== --}}
<script src="{{ asset('js/register-animals.js') }}?v={{ time() }}"></script>
                                                      
</body>
</html>