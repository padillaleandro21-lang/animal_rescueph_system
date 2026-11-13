<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Manage Animals </title>


    <!-- =====================================================
         BOOTSTRAP
    ====================================================== -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- =====================================================
         BOOTSTRAP ICONS
    ====================================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
    


    <!-- =====================================================
         ADMIN SIDEBAR
    ====================================================== -->

    <link
        rel="stylesheet"
        href="{{ asset('css/admin-dashboard.css') }}"
    >


    <!-- =====================================================
         MANAGE ANIMALS
    ====================================================== -->

    <link
        rel="stylesheet"
        href="{{ asset('css/manage-animals.css') }}"
    >
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>


<body>


<!-- =========================================================
     SIDEBAR
========================================================= -->

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
            class="sidebar-link"
        >

            <i class="bi bi-file-earmark-text-fill"></i>

            <span>Reports</span>

        </a>


        <!-- MANAGE ANIMALS -->

        <a
            href="{{ route('admin.manage-animals') }}"
            class="sidebar-link active"
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
     MAIN CONTENT
========================================================= -->

<main class="manage-animals-main">


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <div class="manage-animals-header">

        <div>

            <h1>Manage <span>Animals</span></h1>

            <p>
                Register and manage rescued animals.
            </p>

        </div>


        <a
             href="{{ route('admin.register-animal') }}"
            class="btn-orange"
        >

            <i class="bi bi-plus-lg"></i>

            Register Animal

        </a>



    

   
    
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




    <!-- =====================================================
         SUMMARY CARDS
    ====================================================== -->

    <div class="animal-summary">


        <!-- TOTAL -->

       <div class="animal-summary-card">

    <div class="animal-summary-icon">
        <i class="bi bi-clipboard-check-fill"></i>
    </div>

    <div>
        <span>Total Registered</span>

        <h2>
            {{ $totalRegistered }}
        </h2>

        <small>
            Official animal records
        </small>
    </div>

</div>


   <!-- DOGS -->
<a href="{{ route('admin.registered-dogs') }}" class="animal-summary-link">

    <div class="animal-summary-card dogs-card">

        <div class="animal-summary-icon">
           <i class="fa-solid fa-dog"></i>
        </div>

        <div>
            <span>Registered Dogs</span>

            <h2>
                {{ $registeredDogCount }}
            </h2>

            <small>
                Capacity: {{ $dogCapacity }}
            </small>
        </div>

    </div>

</a>


        <!-- CATS -->
<a
    href="{{ route('admin.registered-cats') }}"
    class="animal-summary-link"
>

    <div class="animal-summary-card cats-card">

        <div class="animal-summary-icon">
            <i class="fa-solid fa-cat"></i>
        </div>

        <div>

            <span>Registered Cats</span>

            <h2>
                {{ $registeredCatCount }}
            </h2>

            <small>
                Capacity: {{ $catCapacity }}
            </small>

        </div>

    </div>

</a>

    </div>
    <!-- =====================================================
         CAPACITY
    ====================================================== -->

    <div class="manage-capacity-card">

        <div class="manage-capacity-header">

            <div>

                <h3>
                    Shelter Capacity
                </h3>

                <p>
                    Current registered animals and available capacity.
                </p>

            </div>

            <a href="{{ route('admin.animal-cages') }}" class="building-button">
    <i class="bi bi-building"></i>
     <h5>Animal Cage </h5>
</a>

        </div>


        <div class="row g-4">


            <!-- DOG CAPACITY -->

            <div class="col-md-6">

                <div class="manage-capacity-item">

                   <div class="manage-capacity-item-header">

                        <span>
                             <i class="fa-solid fa-dog"></i>
                            Dogs
                        </span>

                       <strong>
    {{ $registeredDogCount }} / {{ $dogCapacity }}
</strong>

                    </div>


                    <div class="progress">

                       <div
    class="progress-bar dog-progress"
    data-progress="{{ $dogPercentage }}"
></div> 

                    </div>


                    <small>
    {{ max($dogCapacity - $registeredDogCount, 0) }}
    available spaces
</small>
                </div>

            </div>



            <!-- CAT CAPACITY -->

            <div class="col-md-6">

                <div class="manage-capacity-item">

                   <div class="manage-capacity-item-header"> 

                        <span>
                              <i class="fa-solid fa-cat"></i>
                            Cats
                        </span>

                       <strong>
    {{ $registeredCatCount }} / {{ $catCapacity }}
</strong>

                    </div>


                    <div class="progress">

                    <div
    class="progress-bar cat-progress"
    data-progress="{{ $catPercentage }}"
></div>   

                    </div>


                   <small>
    {{ max($catCapacity - $registeredCatCount, 0) }}
    available spaces
</small>

                </div>

            </div>

        </div>

    </div>



    <!-- =====================================================
         TABS
    ====================================================== -->
<!-- =====================================================
     TABS
====================================================== -->

<div class="animal-tabs">

    <button
        class="animal-tab {{ request('tab') === 'registered' ? '' : 'active' }}"
        data-tab="rescued"
    >
        <i class="bi bi-heart-pulse-fill"></i>
        Rescued Animals
    </button>

    <button
        class="animal-tab {{ request('tab') === 'registered' ? 'active' : '' }}"
        data-tab="registered"
    >
        <i class="bi bi-clipboard-check-fill"></i>
        Registered Animals
    </button>

</div>


    <!-- =====================================================
         RESCUED ANIMALS
    ====================================================== -->
<section
    id="rescued"
    class="animal-tab-content {{ request('tab') === 'registered' ? '' : 'active' }}"
>


        
<div class="animal-section-header">

    <div>
        <h2>Rescued Animals</h2>
        <p>Animals that rescued.</p>
    </div>

    <div class="rescued-header-actions">

        {{-- CSV EXPORT --}}
        <form
           action="{{ route('rescued-animals.export-monthly') }}"
            method="GET"
            class="rescued-export-form"
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

            <button type="submit" class="rescued-export-button">
                <i class="bi bi-file-earmark-spreadsheet"></i>
                Export 
            </button>
        </form>

        {{-- RESCUED COUNT --}}
        <span class="section-count">
            {{ $rescuedAnimals->count() }} Rescued
        </span>

    </div>

</div>




        <div class="animal-table-card">

            <div class="table-responsive">

                <table class="table animal-table">

                    <thead>

                        <tr>

                            <th>Animal</th>

                            <th>Breed</th>

                            <th>Location</th>

                            <th>Date</th>

                            <th>Status</th>

                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody>


                    @forelse($rescuedAnimals as $animal)

                        <tr>


                            <!-- ANIMAL -->

                            <td>

                                <div class="animal-table-info">

                                    <div class="animal-image-wrapper">

                                        @if($animal->animal_image)

                                            <img
                                                src="{{ asset('uploads/animals/' . $animal->animal_image) }}"
                                                class="animal-table-image"
                                                alt="Animal"
                                            >

                                        @else

                                            <div class="animal-image-placeholder">

                                                <i class="bi bi-image"></i>

                                            </div>

                                        @endif

                                    </div>


                                    <div>

                                        <strong>
                                            {{ $animal->animal_type ?? 'Unknown' }}
                                        </strong>

                                        
                                    </div>

                                </div>

                            </td>



                            <!-- BREED -->

                            <td>

                                {{ $animal->breed ?? 'Unknown' }}

                            </td>



                            <!-- LOCATION -->

                            <td>

                                

                                    {{ $animal->city_municipality ?? '' }},
                                    {{ $animal->province ?? '' }}

                                

                            </td>



                            <!-- DATE -->

                            <td>

                                {{ $animal->updated_at->format('M d, Y') }}

                            </td>



                            <!-- STATUS -->

                            <td>

                                <span class="animal-status rescued">

                                    <i class="bi bi-check-circle-fill"></i>

                                    Rescued

                                </span>

                            </td>



                            <!-- ACTIONS -->

                            <td>

                              <div class="animal-actions">

    <!-- VIEW REPORT -->
    <button
        type="button"
        class="animal-action view"
        data-bs-toggle="modal"
        data-bs-target="#viewReportModal"

        data-image="{{ $animal->animal_image }}"

        data-type="{{ $animal->animal_type }}"

        data-breed="{{ $animal->breed }}"

        data-confidence="{{ $animal->confidence }}"

        data-name="{{ $animal->first_name }} {{ $animal->last_name }}"

        data-email="{{ $animal->email }}"

        data-contact="{{ $animal->contact_number }}"

        data-location="{{ $animal->house_street }}, {{ $animal->barangay }}, {{ $animal->city_municipality }}, {{ $animal->province }}"

        data-notes="{{ $animal->additional_notes }}"

        data-date="{{ $animal->updated_at->format('F d, Y h:i A') }}"
    >
        <i class="bi bi-eye-fill"></i>
    </button>


    <!-- DOWNLOAD / EXPORT REPORT -->
    <a
        href="{{ route('admin.rescued-animal.export', $animal->id) }}"
        class="animal-action download"
        title="Download Animal Report"
    >
        <i class="bi bi-download"></i>
    </a>


    <!-- REGISTER ANIMAL -->
    <a
        href="{{ route('admin.register-animal', ['report_id' => $animal->id]) }}"
        class="animal-action register"
        title="Register Animal"
    >
        <i class="bi bi-person-plus-fill"></i>
        Register
    </a>

</div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="empty-table"
                            >

                                <div class="empty-state">

                                    <i class="bi bi-heart-pulse"></i>

                                    <h3>
                                        No Rescued Animals
                                    </h3>

                                    <p>
                                        Animals marked as rescued will appear here.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse


                    </tbody>

                </table>

            </div>

        </div>


        <!-- PAGINATION -->
{{-- PAGINATION --}}
@if($rescuedAnimals->count() > 0)

    <div class="mt-4 text-center">
        <small class="text-muted">
            Showing {{ $rescuedAnimals->count() }} rescued animal(s)
        </small>
    </div>

@endif
    </section>



    <!-- =====================================================
         REGISTERED ANIMALS
    ====================================================== -->

<section
    id="registered"
    class="animal-tab-content {{ request('tab') === 'registered' ? 'active' : '' }}">

        <div class="animal-section-header">

            <div>

                <h2>
                    Registered Animals
                </h2>

                <p>
                    Official Animal Records
                </p>

            </div>

<span class="section-count">

    {{ $totalRegistered }}

    Registered

</span>

        </div>
            {{-- ✅ SUCCESS MESSAGE — nasa loob ng Registered section --}}
    @if(session('success'))

        <div class="alert alert-success animal-registered-success">

            <i class="bi bi-check-circle-fill"></i>

            {{ session('success') }}

        </div>

    @endif



      <div class="animal-table-card">

    <div class="table-responsive">

        <table class="table animal-table">

            <thead>
                <tr>

                    <th>Animal</th>

                    <th>Animal Name</th>

                    <th>Breed</th>

                    <th>Age</th>

                    <th>Status</th>

                    <th>Actions</th>

                </tr>
            </thead>


            <tbody>

            @forelse($registeredAnimals as $animal)

                <tr>

                    {{-- ANIMAL --}}
                    <td>

                        <div class="animal-table-info">

                            <div class="animal-image-wrapper">

                                @if($animal->animal_image)

                                    <img
                                        src="{{ asset('uploads/animals/' . $animal->animal_image) }}"
                                        class="animal-table-image"
                                        alt="{{ $animal->name }}"
                                    >

                                @else

                                    <div class="animal-image-placeholder">

                                        <i class="bi bi-image"></i>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </td>


                    {{-- ANIMAL NAME --}}
                    <td>

                        <strong>
                            {{ $animal->name ?: 'Unknown' }}
                        </strong>

                    </td>


                    {{-- BREED --}}
                    <td>

                        {{ $animal->breed ?: 'Unknown' }}

                    </td>


                    {{-- AGE --}}
                    <td>

                        {{ $animal->age ?: 'Unknown' }}

                    </td>


                    {{-- STATUS --}}
                  <td>
    <span
        class="animal-status registered"
        data-status="{{ strtolower(trim($animal->status)) }}"
    >
        {{ $animal->status }}
    </span>
</td>


                    {{-- ACTIONS --}}
                    <td>

                        <div class="animal-actions">

                            {{-- VIEW REGISTERED ANIMAL --}}

                            <button
                                type="button"
                                class="animal-action view registered-animal-view-btn"
                                title="View Animal"

                                data-bs-toggle="modal"
                                data-bs-target="#viewRegisteredAnimalModal"

                                data-id="{{ $animal->id }}"
                                data-name="{{ $animal->name }}"
                                data-type="{{ $animal->animal_type }}"
                                data-breed="{{ $animal->breed }}"
                                data-age="{{ $animal->age }}"
                                data-gender="{{ $animal->gender }}"
                                data-weight="{{ $animal->weight }}"
                                data-height="{{ $animal->height }}"
                                data-cage="{{ $animal->cage?->cage_number }}"
                                data-status="{{ $animal->status }}"
                                data-date-acquired="{{ optional($animal->date_acquired)->format('F d, Y') }}"
                                data-source="{{ $animal->source_type }}"
                                data-health="{{ $animal->health_condition }}"
                                data-medical-notes="{{ $animal->medical_notes }}"
                                data-additional-notes="{{ $animal->additional_notes }}"

                                data-image="{{ $animal->animal_image }}"

                                data-vaccinations='@json($animal->vaccinations ?? [])'

                                @if(strtolower(trim($animal->animal_type)) === 'cat')

                                    data-edit-url="{{ route('admin.registered-cats.edit', [
                                        'id' => $animal->id,
                                        'from' => 'manage-animals'
                                    ]) }}"

                                @else

                                    data-edit-url="{{ route('admin.registered-dogs.edit', [
                                        'id' => $animal->id,
                                        'from' => 'manage-animals'
                                    ]) }}"

                                @endif
                            >

                                <i class="bi bi-eye-fill"></i>

                            </button>


                            {{-- EDIT REGISTERED ANIMAL --}}

                            @if(strtolower(trim($animal->animal_type)) === 'cat')

                                <a
                                    href="{{ route('admin.registered-cats.edit', $animal->id) }}"
                                    class="animal-action edit"
                                    title="Edit Animal"
                                >
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                            @else

                                <a
                                    href="{{ route('admin.registered-dogs.edit', $animal->id) }}"
                                    class="animal-action edit"
                                    title="Edit Animal"
                                >
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                            @endif
                          {{-- DOWNLOAD REGISTERED ANIMAL --}}
<a
    href="{{ route('admin.registered-animal.export', $animal->id) }}"
    class="animal-action download"
    title="Download Animal Report"
>
    <i class="bi bi-download"></i>
</a>
                        </div>

                    </td>

                </tr>


            @empty

                <tr>

                    <td
                        colspan="6"
                        class="empty-table"
                    >

                        <div class="empty-state">

                            <i class="bi bi-clipboard2"></i>

                            <h3>
                                No Registered Animals
                            </h3>

                            <p>
                                Register an animal to create an official animal record.
                            </p>

                        </div>

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

    {{-- PAGINATION --}}
    @if($registeredAnimals->hasPages())
        <div class="registered-pagination">
            {{ $registeredAnimals->links() }}
        </div>
    @endif
</section>
</main>
 <!-- =========================================================
     VIEW REGISTERED ANIMAL MODAL
========================================================= -->

<div
    class="modal fade"
    id="viewRegisteredAnimalModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content registered-animal-modal">


            <!-- =================================================
                 MODAL HEADER
            ================================================== -->

            <div class="registered-animal-modal-header">

                <div>

                    <span
                        class="registered-animal-modal-label"
                        id="registeredAnimalModalLabel"
                    >
                        REGISTERED DOG
                    </span>

                    <h2
                        id="registeredAnimalModalTitle"
                        class="registered-animal-modal-title"
                    >
                        Dog Details
                    </h2>

                </div>


                <button
                    type="button"
                    class="registered-animal-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >
                    <i class="bi bi-x-lg"></i>
                </button>

            </div>


            <!-- =================================================
                 MODAL BODY
            ================================================== -->

            <div class="registered-animal-modal-body">


                <!-- =============================================
                     TOP INFORMATION
                ============================================== -->

                <div class="registered-animal-top">


                    <!-- IMAGE -->

                    <div class="registered-animal-photo-wrapper">

                        <img
                            id="registeredAnimalModalImage"
                            src=""
                            alt="Animal"
                            class="registered-animal-photo"
                        >

                    </div>


                    <!-- DETAILS -->

                    <div class="registered-animal-main-info">


                        <!-- NAME + STATUS -->

                        <div class="registered-animal-name-row">

                            <div>

                                <span class="registered-animal-name-label">
                                    ANIMAL NAME
                                </span>

                                <h1 id="registeredAnimalModalName">
                                    —
                                </h1>

                            </div>


                            <span
                                id="registeredAnimalModalStatus"
                                class="registered-animal-status"
                            >
                                —
                            </span>

                        </div>


                        <!-- DETAILS GRID -->

                        <div class="registered-animal-info-grid">


                            <!-- ID -->

                            <div class="registered-animal-info-card">

                                <span>
                                    Animal ID
                                </span>

                                <strong id="registeredAnimalModalId">
                                    —
                                </strong>

                            </div>


                            <!-- TYPE -->

                            <div class="registered-animal-info-card">

                                <span>
                                    Animal Type
                                </span>

                                <strong id="registeredAnimalModalType">
                                    —
                                </strong>

                            </div>


                            <!-- BREED -->

                            <div class="registered-animal-info-card">

                                <span>
                                    Breed
                                </span>

                                <strong id="registeredAnimalModalBreed">
                                    —
                                </strong>

                            </div>


                            <!-- AGE -->

                            <div class="registered-animal-info-card">

                                <span>
                                    Age
                                </span>

                                <strong id="registeredAnimalModalAge">
                                    —
                                </strong>

                            </div>


                            <!-- GENDER -->

                            <div class="registered-animal-info-card">

                                <span>
                                    Gender
                                </span>

                                <strong id="registeredAnimalModalGender">
                                    —
                                </strong>

                            </div>


                            <!-- WEIGHT -->

                            <div class="registered-animal-info-card">

                                <span>
                                    Weight
                                </span>

                                <strong id="registeredAnimalModalWeight">
                                    —
                                </strong>

                            </div>


                            <!-- HEIGHT -->

                            <div class="registered-animal-info-card">

                                <span>
                                    Height
                                </span>

                                <strong id="registeredAnimalModalHeight">
                                    —
                                </strong>

                            </div>


                            <!-- CAGE -->

                            <div class="registered-animal-info-card">

                                <span>
                                    Cage
                                </span>

                                <strong id="registeredAnimalModalCage">
                                    —
                                </strong>

                            </div>


                            <!-- DATE -->

                            <div class="registered-animal-info-card">

                                <span>
                                    Date Acquired
                                </span>

                                <strong id="registeredAnimalModalDate">
                                    —
                                </strong>

                            </div>


                            <!-- SOURCE -->

                          


                        </div>

                    </div>

                </div>


                <!-- =================================================
                     LOCATION
                ================================================== -->

               


                    <div
                        id="registeredAnimalModalLocation"
                        class="registered-animal-location"
                    >
                        —
                    </div>

                </div>


                <!-- =================================================
                     HEALTH INFORMATION
                ================================================== -->

                <div class="registered-animal-section">

                    <div class="registered-animal-section-title">

                        <i class="fa-solid fa-heart-pulse"></i>

                        <span>
                            Health Information
                        </span>

                    </div>


                    <div class="registered-animal-health-grid">


                        <div class="registered-animal-health-card">

                            <span>
                                Health Condition
                            </span>

                            <strong id="registeredAnimalModalHealth">
                                —
                            </strong>

                        </div>


                        <div class="registered-animal-health-card">

                            <span>
                                Medical Notes
                            </span>

                            <strong id="registeredAnimalModalMedical">
                                —
                            </strong>

                        </div>


                    </div>

                </div>


                <!-- =================================================
                     VACCINATION
                ================================================== -->

                <div class="registered-animal-section">

                    <div class="registered-animal-section-title">

                        <i class="bi bi-shield-check"></i>

                        <span>
                            Vaccination / Medical Records
                        </span>

                    </div>


                    <div
                        id="registeredAnimalModalVaccinations"
                        class="registered-animal-vaccinations"
                    >
                    </div>

                </div>


                <!-- =================================================
                     ADDITIONAL NOTES
                ================================================== -->

                <div class="registered-animal-section">

                    <div class="registered-animal-section-title">

                        <i class="bi bi-journal-text"></i>

                        <span>
                            Additional Notes
                        </span>

                    </div>


                    <div
                        id="registeredAnimalModalNotes"
                        class="registered-animal-notes"
                    >
                        —
                    </div>

                </div>


            </div>


            <!-- =================================================
                 MODAL FOOTER
            ================================================== -->

            <div class="registered-animal-modal-footer">

                <button
                    type="button"
                    class="registered-animal-close-button"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>


                <a
                    href="#"
                    id="registeredAnimalModalEdit"
                    class="registered-animal-edit-button"
                >

                    <i class="bi bi-pencil-fill"></i>

                    <span>
                        Edit Animal
                    </span>

                </a>

            </div>

        </div>

    </div>

</div>
<!-- =========================================================
     VIEW ANIMAL REPORT MODAL
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
     BOOTSTRAP JAVASCRIPT
========================================================= -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


<!-- =========================================================
     MANAGE ANIMALS JAVASCRIPT
========================================================= -->

<script src="{{ asset('js/manage-animals.js') }}"></script>
{{-- =========================================================
     TAB SWITCHING + URL STATE
========================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const tabs = document.querySelectorAll('.animal-tab');
    const contents = document.querySelectorAll('.animal-tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {

            const target = this.dataset.tab;

            // 1. Update active states
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));

            this.classList.add('active');
            document.getElementById(target)?.classList.add('active');

            // 2. Update URL — save tab state
            const url = new URL(window.location);
            url.searchParams.set('tab', target);

            // 3. Reset page params
            url.searchParams.delete('registered_page');
            url.searchParams.delete('rescued_page');
            url.searchParams.delete('page');

            window.history.replaceState({}, '', url);
        });
    });

});
</script>

</body>

</html>