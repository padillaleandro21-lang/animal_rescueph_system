<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Adoption </title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Adoption CSS --}}
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adoption.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adoption-form.css') }}">
    

</head>

<body>

<header class="main-header">

    <div class="header-container">

        {{-- LOGO --}}
        <div class="logo-section">
            <div class="logo-icon">
                <img src="{{ asset('images/logo.png') }}" alt="Animal Rescue PH Logo">
            </div>
            <div class="logo-text">
                <h1 class="logo-title">
                    Animal Rescue <span>PH</span>
                </h1>
            </div>
        </div>

        {{-- HAMBURGER --}}
        <button class="hamburger-button" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>

        {{-- NAVIGATION --}}
        <nav class="navigation-menu collapse" id="mainNavigation">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
            <a href="{{ route('report-animal') }}" class="nav-link">Report Animal</a>
            <a href="{{ route('adoption') }}" class="nav-link active">Adoption</a>
            <a href="{{ route('about') }}" class="nav-link">About Us</a>
        </nav>

        {{-- LOGIN / USER --}}
        <div class="header-buttons">
            @auth
                <div class="user-account">
                    <button type="button" class="user-account-button" id="userAccountButton" aria-expanded="false">
                        <span class="user-account-icon"><i class="bi bi-person"></i></span>
                        <span class="user-account-name">{{ auth()->user()->name }}</span>
                        <i class="bi bi-chevron-down user-account-arrow"></i>
                    </button>

                    <div class="user-information-dropdown" id="userInformationDropdown">
                        <div class="user-dropdown-header">
                            <div class="user-dropdown-avatar"><i class="bi bi-person"></i></div>
                            <div class="user-dropdown-name">
                                <h5>{{ auth()->user()->name }}</h5>
                                <span>{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                        <div class="user-details">
                            <div class="user-detail-item">
                                <i class="bi bi-person"></i>
                                <div><small>Full Name</small><strong>{{ auth()->user()->name }}</strong></div>
                            </div>
                            <div class="user-detail-item">
                                <i class="bi bi-envelope"></i>
                                <div><small>Email Address</small><strong>{{ auth()->user()->email }}</strong></div>
                            </div>
                            <div class="user-detail-item">
                                <i class="bi bi-person-badge"></i>
                                <div><small>Username</small><strong>{{ auth()->user()->username ?? 'Not provided' }}</strong></div>
                            </div>
                            <div class="user-detail-item">
                                <i class="bi bi-telephone"></i>
                                <div><small>Phone Number</small><strong>{{ auth()->user()->phone ?? 'Not provided' }}</strong></div>
                            </div>
                        </div>
                        <div class="user-dropdown-logout">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="user-logout-button">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login', ['redirect' => url()->full()]) }}" class="login-button">Login</a>
                <a href="{{ route('register', ['redirect' => url()->full()]) }}" class="register-button">Register</a>
            @endauth
        </div>

    </div>

</header>
{{-- =========================================================
     SUCCESS NOTIFICATION (Solid Background)
========================================================= --}}
@if(session('success'))
    <div class="solid-notification success-solid" id="successNotification" role="alert">
        
        <div class="solid-notification-icon">
            <i class="bi bi-check-lg"></i>
        </div>

        <div class="solid-notification-content">
            <h5 class="solid-notification-title">
                Application Submitted!
            </h5>
            <p class="solid-notification-message">
                {{ session('success') }}
            </p>
        </div>

        <button 
            type="button" 
            class="solid-notification-close" 
            onclick="closeNotification('successNotification')"
            aria-label="Close notification"
        >
            <i class="bi bi-x-lg"></i>
        </button>

    </div>
@endif


{{-- =========================================================
     ERROR NOTIFICATION (Solid Background)
========================================================= --}}
@if(session('error'))
    <div class="solid-notification error-solid" id="errorNotification" role="alert">
        
        <div class="solid-notification-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>

        <div class="solid-notification-content">
            <h5 class="solid-notification-title">
                Oops! Something went wrong
            </h5>
            <p class="solid-notification-message">
                {{ session('error') }}
            </p>
        </div>

        <button 
            type="button" 
            class="solid-notification-close" 
            onclick="closeNotification('errorNotification')"
            aria-label="Close notification"
        >
            <i class="bi bi-x-lg"></i>
        </button>

    </div>
@endif
{{-- =========================================================
     VALIDATION ERROR NOTIFICATION (Solid Background)
========================================================= --}}
@if($errors->any())
    <div class="solid-notification error-solid" id="validationNotification" role="alert">

        <div class="solid-notification-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>

        <div class="solid-notification-content">
            <h5 class="solid-notification-title">
                Please check the form
            </h5>
            <p class="solid-notification-message">
                {{ $errors->first() }}
            </p>
        </div>

        <button
            type="button"
            class="solid-notification-close"
            onclick="closeNotification('validationNotification')"
            aria-label="Close notification"
        >
            <i class="bi bi-x-lg"></i>
        </button>

    </div>
@endif

{{-- HERO --}}
<section class="adoption-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <span class="hero-small"><i class="bi bi-paw-fill"></i> GIVE AN ANIMAL A SECOND CHANCE</span>
        <h2>Find your perfect companion</h2>
        <p>Give a loving home to a pet in need.<br>Every adoption makes a difference.</p>
    </div>
</section>

{{-- MAIN ADOPTION PAGE --}}
<main class="adoption-page">
    <div class="adoption-container">

        <div class="section-heading">
            <div>
                <span class="section-kicker">FIND YOUR COMPANION</span>
                <h2>Animals Available for Adoption</h2>
            </div>
            <div class="available-count">
                <i class="bi bi-heart-fill"></i> {{ $animals->count() }} Available
            </div>
        </div>

        {{-- FILTER SECTION --}}
        <section class="filter-section">
            <form action="{{ route('adoption') }}" method="GET" id="adoptionFilterForm" class="adoption-filter-form">

                {{-- ANIMAL TYPE FILTER --}}
                <div class="filter-box">
                    <div class="filter-icon filter-icon-black"><i class="bi bi-funnel-fill"></i></div>
                    <div class="filter-content">
                        <label for="animalTypeButton">Animal Type</label>
                        <div class="custom-select" id="animalTypeDropdown">
                            <button type="button" class="custom-select-button" id="animalTypeButton" aria-haspopup="listbox" aria-expanded="false">
                                <span id="animalTypeSelected">{{ request('animal_type') ?: 'All Animals' }}</span>
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            <div class="custom-select-menu" id="animalTypeMenu" role="listbox">
                                <button type="button" class="custom-option {{ !request('animal_type') ? 'selected' : '' }}" data-value="">
                                    <span><i class="bi bi-grid-fill"></i> All Animals</span>
                                    <i class="bi bi-check2 option-check"></i>
                                </button>
                                @foreach($animalTypes as $type)
                                    <button type="button" class="custom-option {{ strtolower(request('animal_type')) === strtolower($type) ? 'selected' : '' }}" data-value="{{ $type }}">
                                        <span><i class="bi bi-tag-fill"></i> {{ $type }}</span>
                                        <i class="bi bi-check2 option-check"></i>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="animal_type" id="animalTypeInput" value="{{ request('animal_type') }}">
                    </div>
                </div>

                {{-- BREED FILTER --}}
                <div class="filter-box breed-filter-box">
                    <div class="filter-icon filter-icon-orange"><i class="bi bi-tag-fill"></i></div>
                    <div class="filter-content">
                        <label for="breedButton">Breed</label>
                        <div class="custom-select" id="breedDropdown">
                            <button type="button" class="custom-select-button" id="breedButton" aria-haspopup="listbox" aria-expanded="false">
                                <span id="breedSelected">{{ request('breed') ?: 'All Breeds' }}</span>
                                <i class="fa-solid fa-paw"></i>
                            </button>
                            <div class="custom-select-menu" id="breedMenu" role="listbox">
                                <button type="button" class="custom-option breed-option selected" data-value="" data-animal-type="all" data-breed="">
                                    <span><i class="bi bi-grid-fill"></i> All Breeds</span>
                                    <i class="bi bi-check2 option-check"></i>
                                </button>
                                @foreach($breedsByType as $animalType => $typeBreeds)
                                    @foreach($typeBreeds as $breed)
                                        <button type="button" class="custom-option breed-option" data-value="{{ $breed }}" data-animal-type="{{ strtolower(trim($animalType)) }}" data-breed="{{ strtolower(trim($breed)) }}">
                                            <span><i class="fa-solid fa-paw"></i> {{ $breed }}</span>
                                            <i class="bi bi-check2 option-check"></i>
                                        </button>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="breed" id="breedInput" value="{{ request('breed') }}">
                    </div>
                </div>

                <button type="submit" class="filter-submit">
                    <i class="bi bi-search"></i><span>Filter</span>
                </button>

                @if(request()->filled('animal_type') || request()->filled('breed'))
                    <a href="{{ route('adoption') }}" class="clear-filter">
                        <i class="bi bi-x-circle"></i><span>Clear</span>
                    </a>
                @endif
            </form>
        </section>

        {{-- ANIMAL GRID --}}
        <section class="animals-section">
            @forelse($animals as $animal)
                <article class="animal-card" data-type="{{ strtolower(trim($animal->animal_type)) }}" data-breed="{{ strtolower(trim($animal->breed ?? '')) }}">

                    {{-- IMAGE --}}
                    <div class="animal-card-image">
                        @if($animal->animal_image)
                            <img src="{{ asset('uploads/animals/' . $animal->animal_image) }}" alt="{{ $animal->name }}">
                        @else
                            <div class="animal-image-placeholder">
                                <i class="bi bi-image"></i>
                                <span>No Image</span>
                            </div>
                        @endif
                        <span class="adoption-badge"><i class="bi bi-heart-fill"></i> For Adoption</span>
                    </div>

                    {{-- DETAILS --}}
                    <div class="animal-card-body">
                        <div class="animal-type-label">{{ $animal->animal_type }}</div>
                        <h3>{{ $animal->name }}</h3>
                        <p class="animal-meta">
                            <span>{{ $animal->breed ?: 'Mixed Breed' }}</span>
                            <b>•</b>
                            <span>{{ $animal->gender ?: 'Unknown' }}</span>
                            <b>•</b>
                            <span>{{ $animal->age ?: 'Unknown' }}</span>
                        </p>

                        <div class="animal-card-actions">

                            {{-- VIEW --}}
                            <button type="button" class="view-button"
                                data-bs-toggle="modal"
                                data-bs-target="#animalViewModal"
                                data-id="{{ $animal->id }}"
                                data-name="{{ $animal->name }}"
                                data-type="{{ $animal->animal_type }}"
                                data-breed="{{ $animal->breed }}"
                                data-age="{{ $animal->age }}"
                                data-gender="{{ $animal->gender }}"
                                data-weight="{{ $animal->weight }}"
                                data-height="{{ $animal->height }}"
                                data-cage="{{ $animal->cage->cage_number ?? '' }}"
                                data-status="{{ $animal->status }}"
                                data-date="{{ optional($animal->date_acquired)->format('F d, Y') }}"
                                data-source="{{ $animal->source_type }}"
                                data-location="{{ $animal->location_found }}"
                                data-health="{{ $animal->health_condition }}"
                                data-medical="{{ $animal->medical_notes }}"
                                data-notes="{{ $animal->additional_notes }}"
                                data-image="{{ $animal->animal_image ? asset('uploads/animals/' . $animal->animal_image) : '' }}"
                                data-vaccinations='@json($animal->vaccinations)'>
                                <i class="bi bi-eye"></i> View
                            </button>

                            {{-- ADOPT --}}
                            @auth
                                <button type="button" class="btn btn-primary adopt-btn"
                                    data-animal-id="{{ $animal->id }}"
                                    data-animal-name="{{ $animal->name }}"
                                    data-animal-type="{{ $animal->animal_type }}"
                                    data-animal-breed="{{ $animal->breed }}"
                                    data-animal-age="{{ $animal->age }}"
                                    data-animal-gender="{{ $animal->gender }}"
                                    data-animal-image="{{ $animal->animal_image ? asset('uploads/animals/' . $animal->animal_image) : '' }}"
                                    data-action-url="{{ route('adoption.apply', $animal->id) }}">
                                    <i class="bi bi-heart-fill"></i> Adopt
                                </button>
                            @else
                                <button type="button" class="adopt-button guest-adopt-button" data-animal-id="{{ $animal->id }}">
                                    <i class="bi bi-heart-fill"></i> Adopt
                                </button>
                            @endauth

                        </div>
                    </div>

                </article>
            @empty
                <div class="no-animals">
                    <div class="no-animals-icon"><i class="bi bi-heart"></i></div>
                    <h3>No Animals Available</h3>
                    <p>There are currently no animals available for adoption.</p>
                </div>
            @endforelse
        </section>

    </div>
</main>

{{-- =========================================================
     VIEW ANIMAL MODAL (Existing)
========================================================= --}}
<div class="modal fade" id="animalViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content animal-modal">

            <div class="modal-header animal-modal-header">
                <div>
                    <span>REGISTERED ANIMAL</span>
                    <h2 id="modalAnimalTitle">Animal Details</h2>
                </div>
                <button type="button" class="modal-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="modal-main-grid">
                    <div class="modal-image-area">
                        <div class="modal-image-wrapper">
                            <img id="modalAnimalImage" src="" alt="Animal">
                        </div>
                    </div>
                    <div class="modal-information">
                        <div class="modal-animal-name-label">ANIMAL NAME</div>
                        <h3 id="modalAnimalName">—</h3>
                        <div class="modal-status">
                            <span>●</span>
                            <strong id="modalAnimalStatus">For Adoption</strong>
                        </div>
                        <div class="modal-info-grid">
                            <div class="modal-info-box"><small>Animal ID</small><strong id="modalAnimalId">—</strong></div>
                            <div class="modal-info-box"><small>Animal Type</small><strong id="modalAnimalType">—</strong></div>
                            <div class="modal-info-box"><small>Breed</small><strong id="modalAnimalBreed">—</strong></div>
                            <div class="modal-info-box"><small>Age</small><strong id="modalAnimalAge">—</strong></div>
                            <div class="modal-info-box"><small>Gender</small><strong id="modalAnimalGender">—</strong></div>
                            <div class="modal-info-box"><small>Weight</small><strong id="modalAnimalWeight">—</strong></div>
                            <div class="modal-info-box"><small>Height</small><strong id="modalAnimalHeight">—</strong></div>
                            <div class="modal-info-box"><small>Cage</small><strong id="modalAnimalCage">—</strong></div>
                            <div class="modal-info-box"><small>Date Acquired</small><strong id="modalAnimalDate">—</strong></div>
                            <div class="modal-info-box"><small>Registration Source</small><strong id="modalAnimalSource">—</strong></div>
                        </div>
                    </div>
                </div>

                <div class="modal-section">
                    <h4><i class="bi bi-geo-alt-fill"></i> Location Found</h4>
                    <p id="modalAnimalLocation">—</p>
                </div>

                <div class="modal-section">
                    <h4><i class="bi bi-heart-pulse-fill"></i> Health Information</h4>
                    <div class="modal-two-column">
                        <div class="modal-info-box"><small>Health Condition</small><strong id="modalAnimalHealth">—</strong></div>
                        <div class="modal-info-box"><small>Medical Notes</small><strong id="modalAnimalMedical">—</strong></div>
                    </div>
                </div>

                <div class="modal-section">
                    <h4><i class="bi bi-shield-check"></i> Vaccination / Medical Records</h4>
                    <div id="modalAnimalVaccinations" class="vaccination-list">
                        <span class="no-vaccination">No vaccination records</span>
                    </div>
                </div>

                <div class="modal-section">
                    <h4><i class="bi bi-journal-text"></i> Additional Notes</h4>
                    <p id="modalAnimalNotes">—</p>
                </div>
            </div>

            <div class="modal-footer animal-modal-footer">
                <button type="button" class="modal-close-button" data-bs-dismiss="modal">Close</button>

                @auth
                    <a href="{{ route('adoption.show', $animal->id) }}" id="modalAdoptButton" class="modal-adopt-button">
                        <i class="bi bi-heart-fill"></i> Adopt
                    </a>
                @else
                    <button type="button" id="modalLoginAdoptButton" class="modal-adopt-button">
                        <i class="bi bi-heart-fill"></i> Adopt
                    </button>
                @endauth
            </div>

        </div>
    </div>
</div>

{{-- =========================================================
     LOGIN REQUIRED MODAL
========================================================= --}}
<div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content login-required-modal">
            <div class="login-required-icon"><i class="bi bi-lock-fill"></i></div>
            <h3>Login Required</h3>
            <p>You need to log in to your account before you can apply to adopt an animal.</p>
            <div class="login-required-actions">
                <a href="{{ route('login', ['redirect' => url()->full()]) }}" id="loginRequiredButton" class="login-required-login">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
                <a href="{{ route('register', ['redirect' => url()->full()]) }}" id="loginRequiredRegisterButton" class="login-required-register">
                    <i class="bi bi-person-plus"></i> Register
                </a>
            </div>
            <button type="button" class="login-required-close" data-bs-dismiss="modal">Maybe Later</button>
        </div>
    </div>
</div>

{{-- =========================================================
     ADOPTION WIZARD MODAL (Multi-Step Form)
========================================================= --}}
<div class="modal fade" id="adoptionWizardModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Adoption Application</h5>
               <button type="button" class="btn-close" aria-label="Close" onclick="confirmExit()"></button>
            </div>

            <div class="modal-body">

                {{-- STEP INDICATOR --}}
                <div class="step-indicator">
                    <div class="step-dot active" id="dot1">1</div>
                    <div class="step-dot" id="dot2">2</div>
                    <div class="step-dot" id="dot3">3</div>
                    <div class="step-dot" id="dot4">4</div>
                </div>

                {{-- ANIMAL INFO (Dynamic via JS) --}}
                <div id="modalAnimalInfo" class="mb-4 p-3 bg-light rounded-3">
                    <div class="text-center text-muted">
                        <i class="bi bi-paw-fill"></i> Loading animal information...
                    </div>
                </div>

                {{-- ERROR MESSAGES --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please check the form.</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="" method="POST" enctype="multipart/form-data" id="adoptionApplicationForm">
                    @csrf
                    <input type="hidden" name="animal_id" id="modalAnimalIdInput">

                    {{-- ==========================================
                         STEP 1: APPLICANT & HOUSEHOLD
                    =========================================== --}}
                    <div class="form-step active" id="step1">
                        <div class="row g-4">

                            {{-- Applicant Information --}}
                            <div class="col-md-6">
                                <div class="form-card h-100">
                                    <div class="card-title mb-3">
                                        <h5 class="fw-bold"><i class="bi bi-person-vcard me-2 text-primary"></i>Applicant Information</h5>
                                    </div>

@auth
    @php
        $fullName = trim(auth()->user()->name ?? '');

        $nameParts = preg_split(
            '/\s+/',
            $fullName,
            -1,
            PREG_SPLIT_NO_EMPTY
        );

        $lastName = '';

        if (count($nameParts) > 1) {
            $lastName = array_pop($nameParts);
        }

        $firstName = implode(' ', $nameParts);
    @endphp

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" value="{{ $firstName }}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" value="{{ $lastName }}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" value="{{ auth()->user()->email ?? '' }}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" value="{{ auth()->user()->phone ?? '' }}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Occupation <span class="text-danger">*</span></label>
                                                <select name="occupation" class="form-select" required>
                                                    <option value="">Select Occupation</option>
                                                    @foreach(['Student', 'Employed', 'Self-employed', 'Business Owner', 'Government Employee', 'Private Employee', 'Unemployed', 'Retired', 'Other'] as $occupation)
                                                        <option value="{{ $occupation }}" {{ old('occupation') === $occupation ? 'selected' : '' }}>{{ $occupation }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Civil Status <span class="text-danger">*</span></label>
                                                <select name="civil_status" class="form-select" required>
                                                    <option value="">Select Civil Status</option>
                                                    @foreach(['Single', 'Married', 'Widowed', 'Separated', 'Other'] as $status)
                                                        <option value="{{ $status }}" {{ old('civil_status') === $status ? 'selected' : '' }}>{{ $status }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endauth
                                </div>
                            </div>

                            {{-- Address & Household --}}
                          <div class="col-md-6">
    <div class="form-card h-100">
        <div class="card-title mb-3">
            <h5 class="fw-bold"><i class="bi bi-geo-alt me-2 text-primary"></i>Address & Household</h5>
        </div>
        <div class="row g-3">

            {{-- REGION --}}
            <div class="col-md-6">
                <label class="form-label">Region <span class="text-danger">*</span></label>
                <select
                    name="region"
                    id="region"
                    class="form-select"
                    data-old-value="{{ old('region') }}"
                    required
                >
                    <option value="">Select Region</option>
                </select>
            </div>

            {{-- PROVINCE --}}
            <div class="col-md-6">
                <label class="form-label">Province <span class="text-danger">*</span></label>
                <select
                    name="province"
                    id="province"
                    class="form-select"
                    data-old-value="{{ old('province') }}"
                    required
                    disabled
                >
                    <option value="">Select Province</option>
                </select>
            </div>

            {{-- CITY / MUNICIPALITY --}}
            <div class="col-md-6">
                <label class="form-label">City/Municipality <span class="text-danger">*</span></label>
                <select
                    name="city_municipality"
                    id="cityMunicipality"
                    class="form-select"
                    data-old-value="{{ old('city_municipality') }}"
                    required
                    disabled
                >
                    <option value="">Select City/Municipality</option>
                </select>
            </div>

            {{-- BARANGAY --}}
            <div class="col-md-6">
                <label class="form-label">Barangay <span class="text-danger">*</span></label>
                <select
                    name="barangay"
                    id="barangay"
                    class="form-select"
                    data-old-value="{{ old('barangay') }}"
                    required
                    disabled
                >
                    <option value="">Select Barangay</option>
                </select>
            </div>

            {{-- HOUSE / UNIT / STREET (nasa ibaba, hindi required) --}}
            <div class="col-12">
                <label class="form-label">
                    House/Unit/Street
                    <small class="text-muted fw-normal">(Optional)</small>
                </label>
                <input
                    type="text"
                    name="house_street"
                    class="form-control"
                    value="{{ old('house_street') }}"
                    placeholder="e.g. 123 Mabini St. (optional)"
                    maxlength="255"
                >
            </div>

            <div class="col-12 mt-3">
                <label class="form-label fw-bold">Type of Residence <span class="text-danger">*</span></label>
                @foreach(['Owned house', 'Rented house', 'Apartment/Condominium', 'Boarding house', 'Other'] as $residence)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="residence_type" value="{{ $residence }}" id="res_{{ $loop->index }}" required>
                        <label class="form-check-label" for="res_{{ $loop->index }}">{{ $residence }}</label>
                    </div>
                
                                            @endforeach
                                            <input type="text" name="residence_other" id="residenceOther" class="form-control mt-2" placeholder="Please specify..." style="display:none;">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Do you have permission from your landlord? <span class="text-danger">*</span></label>
                                            <div class="d-flex gap-3">
                                                <div class="form-check"><input class="form-check-input" type="radio" name="landlord_permission" value="Yes" required><label class="form-check-label">Yes</label></div>
                                                <div class="form-check"><input class="form-check-input" type="radio" name="landlord_permission" value="No"><label class="form-check-label">No</label></div>
                                                <div class="form-check"><input class="form-check-input" type="radio" name="landlord_permission" value="Not applicable"><label class="form-check-label">Not applicable</label></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">No. of people in household <span class="text-danger">*</span></label>
                                            <input type="number" name="household_members" class="form-control" min="1" max="100" value="{{ old('household_members', 1) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Are all members supportive? <span class="text-danger">*</span></label>
                                            <div class="d-flex gap-3">
                                                <div class="form-check"><input class="form-check-input" type="radio" name="household_support" value="Yes" required><label class="form-check-label">Yes</label></div>
                                                <div class="form-check"><input class="form-check-input" type="radio" name="household_support" value="No"><label class="form-check-label">No</label></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- ==========================================
                         STEP 2: BACKGROUND & COMMITMENT
                    =========================================== --}}
                    <div class="form-step" id="step2">
                        <div class="row g-4">

                            {{-- Adoption Background --}}
                            <div class="col-12">
                                <div class="form-card">
                                    <h5 class="fw-bold mb-3"><i class="bi bi-house-heart me-2 text-primary"></i>Adoption Background</h5>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">1. Why do you want to adopt this animal? <span class="text-danger">*</span></label>
                                        <select name="reason_for_adoption" class="form-select mb-2" required>
                                            <option value="">Select your reason</option>
                                            <option value="Companion">I want a companion</option>
                                            <option value="Family">I want a pet for my family</option>
                                            <option value="Rescue Support">I want to help a rescued animal</option>
                                            <option value="Personal Interest">I have a personal interest in animals</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <textarea name="reason_explanation" class="form-control" rows="2" placeholder="Additional explanation (optional)...">{{ old('reason_explanation') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">2. Who will be primarily responsible? <span class="text-danger">*</span></label>
                                        @foreach(['Myself', 'My spouse/partner', 'Parent/guardian', 'Another household member', 'Other'] as $responsible)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="primary_responsible" value="{{ $responsible }}" required>
                                                <label class="form-check-label">{{ $responsible }}</label>
                                            </div>
                                        @endforeach
                                        <input type="text" name="primary_responsible_other" id="responsibleOther" class="form-control mt-2" placeholder="Please specify..." style="display:none;">
                                    </div>
                                </div>
                            </div>

                            {{-- Adoption Commitment --}}
                            <div class="col-12">
                                <div class="form-card">
                                    <h5 class="fw-bold mb-3"><i class="bi bi-heart me-2 text-primary"></i>Adoption Commitment</h5>
                                    @php
                                        $commitments = [
                                            ['name' => 'commitment_food_shelter_care', 'text' => 'Are you willing to provide proper food, shelter, care, and attention to the animal?'],
                                            ['name' => 'commitment_veterinary_care', 'text' => 'Are you willing to provide necessary veterinary care when needed?'],
                                            ['name' => 'commitment_safety', 'text' => 'Are you willing to keep the animal safe and prevent neglect or abuse?'],
                                            ['name' => 'commitment_policies', 'text' => "Are you willing to comply with the organization's adoption policies and requirements?"],
                                            ['name' => 'commitment_post_adoption', 'text' => 'Are you willing to provide updates or participate in post-adoption monitoring when requested by Animal Rescue PH?'],
                                        ];
                                    @endphp
                                    @foreach($commitments as $index => $commitment)
                                        <div class="mb-3 p-3 bg-light rounded">
                                            <label class="form-label fw-bold d-block">{{ $index + 1 }}. {{ $commitment['text'] }} <span class="text-danger">*</span></label>
                                            <div class="d-flex gap-4">
                                                <div class="form-check"><input class="form-check-input" type="radio" name="{{ $commitment['name'] }}" value="1" required><label class="form-check-label">Yes</label></div>
                                                <div class="form-check"><input class="form-check-input" type="radio" name="{{ $commitment['name'] }}" value="0" required><label class="form-check-label">No</label></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- ==========================================
                         STEP 3: ID & AGREEMENT
                    =========================================== --}}
                    <div class="form-step" id="step3">
                        <div class="row g-4">

                            {{-- ID Upload --}}
                            <div class="col-12">
                                <div class="form-card">
                                    <h5 class="fw-bold mb-3"><i class="bi bi-file-earmark-person me-2 text-primary"></i>Identification Document</h5>
                                    <div class="row align-items-center">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <label class="upload-box w-100" for="valid_id">
                                                <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
                                                <strong class="d-block mt-2">Upload Valid Government-Issued ID</strong>
                                                <small class="text-muted d-block">Click to upload or drag and drop</small>
                                                <small class="text-muted d-block">JPG, JPEG, PNG or PDF (Max. 5 MB)</small>
                                                <span class="btn btn-outline-primary btn-sm mt-3">Choose File</span>
                                                <input type="file" name="valid_id" id="valid_id" accept=".jpg,.jpeg,.png,.pdf" required hidden>
                                            </label>
                                            <div id="fileName" class="mt-2 text-success fw-bold text-center"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 bg-light rounded-3">
                                                <strong class="d-block mb-2">Accepted Valid IDs:</strong>
                                                <ul class="mb-0 text-muted small">
                                                    <li>Philippine National ID</li>
                                                    <li>Driver's License</li>
                                                    <li>Passport</li>
                                                    <li>Voter's ID</li>
                                                    <li>PRC ID</li>
                                                    <li>Other government-issued ID</li>
                                                </ul>
                                                <div class="mt-3 text-primary small">
                                                    <i class="bi bi-shield-check me-1"></i> The uploaded ID will be verified by the organization.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Agreement --}}
                            <div class="col-12">
                                <div class="form-card">
                                    <h5 class="fw-bold mb-3"><i class="bi bi-clipboard-check me-2 text-primary"></i>Agreement</h5>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="agreement_information" value="1" id="agree1" required>
                                        <label class="form-check-label" for="agree1">
                                            I certify that the information I provided in this application is true and complete. I understand that Animal Rescue PH may review and verify the information provided before approving my adoption application.
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="agreement_not_automatic" value="1" id="agree2" required>
                                        <label class="form-check-label" for="agree2">
                                            I understand that submitting this application does not automatically mean that my adoption request has been approved.
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="agreement_policies" value="1" id="agree3" required>
                                        <label class="form-check-label" for="agree3">
                                            I agree to comply with the adoption requirements and policies of Animal Rescue PH.
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- ==========================================
                         STEP 4: REVIEW & SUBMIT
                    =========================================== --}}
                    <div class="form-step" id="step4">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold text-success"><i class="bi bi-check-circle-fill me-2"></i>Review Your Application</h4>
                            <p class="text-muted">Please review all the information below before submitting.</p>
                        </div>

                        <div id="reviewContent">
                            {{-- Dynamic Review Content injected by JS --}}
                        </div>
                        {{-- ==========================================
     TERMS & PRIVACY AGREEMENT
========================================== --}}
<div class="terms-privacy-section mt-4">

    <div class="form-check">
        <input
            class="form-check-input"
            type="checkbox"
            id="termsPrivacyCheck"
        >
        <label class="form-check-label" for="termsPrivacyCheck">
            I have read and agree to the
            <button
                type="button"
                class="btn-link-inline"
                data-bs-toggle="modal"
                data-bs-target="#termsModal"
            >
                Terms and Conditions
            </button>
            and
            <button
                type="button"
                class="btn-link-inline"
                data-bs-toggle="modal"
                data-bs-target="#privacyModal"
            >
                Privacy Policy
            </button>
            of Animal Rescue PH.
        </label>
    </div>

</div>

                        <div class="alert alert-warning mt-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Important Reminder:</strong> Incomplete or false information may result in the rejection of your application.
                        </div>
                    </div>

                </form>
            </div>

            {{-- MODAL FOOTER --}}
            <div class="modal-footer border-0 pt-0 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </button>
                <div style="flex: 1;"></div>
                <button type="button" class="btn btn-primary" id="nextBtn" style="background-color: #ff6b35; border: none;">
                    Next <i class="bi bi-arrow-right ms-1"></i>
                </button>
                <button type="submit" form="adoptionApplicationForm" class="btn btn-success" id="submitApplication" style="display: none;">
                    <i class="bi bi-send-fill me-1"></i> Submit Application
                </button>
            </div>

        </div>
    </div>
</div>

{{-- =========================================================
     USER DROPDOWN SCRIPT
========================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const userButton = document.getElementById('userAccountButton');
    const userDropdown = document.getElementById('userInformationDropdown');

    if (userButton && userDropdown) {
        userButton.addEventListener('click', function (event) {
            event.stopPropagation();
            const isOpen = userDropdown.classList.contains('show');
            userDropdown.classList.toggle('show', !isOpen);
            userButton.classList.toggle('open', !isOpen);
            userButton.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
        });

        document.addEventListener('click', function (event) {
            if (!userDropdown.contains(event.target) && !userButton.contains(event.target)) {
                userDropdown.classList.remove('show');
                userButton.classList.remove('open');
                userButton.setAttribute('aria-expanded', 'false');
            }
        });
    }
});
</script>

{{-- BOOTSTRAP --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- ADOPTION JS (original) --}}
<script src="{{ asset('js/adoption.js') }}"></script>

{{-- ADOPTION FORM JS (multi-step wizard + PSGC API) --}}
<script src="{{ asset('js/adoption-form.js') }}"></script>
 {{-- =========================================================
     EXIT CONFIRMATION MODAL
========================================================= --}}
<div class="modal fade" id="exitConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 18px; border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
            
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center pt-0 px-4">
                <div class="mb-3 d-inline-flex align-items-center justify-content-center" 
                     style="width: 80px; height: 80px; border-radius: 50%; background: #fff7ed; color: #f59e0b; font-size: 40px;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h4 class="fw-bold mb-2" style="font-size: 22px; color: #111;">Are you sure?</h4>
                <p class="text-muted mb-0" style="font-size: 15px; font-weight: 500;">
                    Your progress will be lost if you close this form. Do you want to exit?
                </p>
            </div>

            <div class="modal-footer border-0 justify-content-center pb-4 pt-3" style="gap: 10px;">
                <button type="button" class="btn" data-bs-dismiss="modal" 
                        style="border-radius: 50px; padding: 12px 28px; font-weight: 800; font-size: 14px; background: #f1f5f9; color: #333; border: 2px solid #e2e8f0;">
                    <i class="bi bi-arrow-left me-1"></i> Cancel
                </button>
                <button type="button" class="btn" id="confirmExitBtn"
                        style="border-radius: 50px; padding: 12px 28px; font-weight: 800; font-size: 14px; background: #ef4444; color: #fff; border: none; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);">
                    <i class="bi bi-x-circle me-1"></i> Yes, Exit
                </button>
            </div>

        </div>
    </div>
</div>
{{-- =========================================================
     TERMS AND CONDITIONS MODAL
========================================================= --}}
<div class="modal fade" id="termsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 18px; border: none;">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-file-text-fill me-2 text-primary"></i>
                    Terms and Conditions
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">1. Eligibility</h6>
                <p>Applicants must be at least 18 years old and capable of providing proper care for the animal.</p>

                <h6 class="fw-bold">2. Adoption Requirements</h6>
                <p>All information provided in this application must be true and complete. False or misleading information may result in immediate rejection of the application.</p>

                <h6 class="fw-bold">3. Commitment to Animal Welfare</h6>
                <p>The adopter agrees to provide proper food, shelter, veterinary care, and safety for the adopted animal throughout its lifetime.</p>

                <h6 class="fw-bold">4. Post-Adoption Monitoring</h6>
                <p>Animal Rescue PH may conduct follow-up monitoring to ensure the animal's welfare. Adopters agree to cooperate with reasonable monitoring requests.</p>

                <h6 class="fw-bold">5. Non-Transfer Policy</h6>
                <p>Adopted animals may not be sold, transferred, or given away to another person without prior written approval from Animal Rescue PH.</p>

                <h6 class="fw-bold">6. Return Policy</h6>
                <p>If the adopter can no longer care for the animal, they must return it to Animal Rescue PH rather than abandoning or rehoming it elsewhere.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    I Understand
                </button>
            </div>
        </div>
    </div>
</div>


{{-- =========================================================
     PRIVACY POLICY MODAL
========================================================= --}}
<div class="modal fade" id="privacyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 18px; border: none;">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-shield-lock-fill me-2 text-primary"></i>
                    Privacy Policy
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold">1. Information We Collect</h6>
                <p>We collect personal information such as your name, email, contact number, address, occupation, and valid government-issued ID for adoption verification purposes.</p>

                <h6 class="fw-bold">2. How We Use Your Information</h6>
                <p>Your information is used solely to process your adoption application, verify your identity, and conduct post-adoption monitoring.</p>

                <h6 class="fw-bold">3. Data Protection</h6>
                <p>All personal data is stored securely and will not be shared with third parties without your explicit consent, except as required by law.</p>

                <h6 class="fw-bold">4. Data Retention</h6>
                <p>Your information is retained only as long as necessary for adoption monitoring and legal compliance. You may request deletion after the retention period.</p>

                <h6 class="fw-bold">5. Your Rights</h6>
                <p>Under the Data Privacy Act of 2012 (RA 10173), you have the right to access, correct, or request deletion of your personal data. Contact us to exercise these rights.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    I Understand
                </button>
            </div>
        </div>
    </div>
</div>
</body>

</html>