<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Application</title>
    
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ asset('css/adoption-form.css') }}">
    
    <style>
        /* Dagdag na CSS para sa Multi-step Modal (Pwede mong ilipat sa adoption-form.css) */
        .modal-content { border-radius: 20px; border: none; }
        .step-indicator { display: flex; justify-content: space-between; margin-bottom: 20px; position: relative; }
        .step-indicator::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 2px; background: #e0e0e0; z-index: 1; transform: translateY(-50%); }
        .step-dot { width: 35px; height: 35px; border-radius: 50%; background: #e0e0e0; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #fff; position: relative; z-index: 2; transition: all 0.3s; }
        .step-dot.active { background: #ff6b35; box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.2); }
        .step-dot.completed { background: #28a745; }
        .form-step { display: none; animation: fadeIn 0.4s ease-in-out; }
        .form-step.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Review Box Styles */
        .review-box { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 10px; padding: 15px; margin-bottom: 15px; }
        .review-box h5 { font-size: 16px; font-weight: 700; color: #ff6b35; margin-bottom: 10px; border-bottom: 1px solid #dee2e6; padding-bottom: 5px; }
        .review-item { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; }
        .review-label { color: #6c757d; font-weight: 500; }
        .review-value { color: #212529; font-weight: 600; text-align: right; max-width: 60%; }
        
        /* Upload Box Styling */
        .upload-box { display: block; border: 2px dashed #ccc; padding: 30px; text-align: center; border-radius: 10px; cursor: pointer; transition: border-color 0.3s; }
        .upload-box:hover { border-color: #ff6b35; }
    </style>
</head>

<body>
<main class="adoption-form-page">
    <!-- HERO -->
    <section class="application-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="breadcrumb-area"><strong>Adoption Application Form</strong></div>
            <h1>Adoption <span>Application Form</span></h1>
            <p>Fill out the form below to apply for the adoption of your chosen animal.</p>
        </div>
        <div class="hero-pets">
            <img src="{{ asset('images/catanddog.png') }}" alt="Pets">
        </div>
        <div class="hero-message">
            Give them<br> a <span>second chance</span> <i class="bi bi-heart-fill"></i>
        </div>
    </section>

    <!-- MULTI-STEP MODAL (Auto-open on page load) -->
    <div class="modal fade" id="adoptionWizardModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                
                <!-- Modal Header -->
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Adoption Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="confirmExit()"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    
                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step-dot active" id="dot1">1</div>
                        <div class="step-dot" id="dot2">2</div>
                        <div class="step-dot" id="dot3">3</div>
                        <div class="step-dot" id="dot4">4</div>
                    </div>

                    <!-- Error Message -->
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

                    <form action="{{ route('adoption.apply', $animal->id) }}" method="POST" enctype="multipart/form-data" id="adoptionApplicationForm">
                        @csrf

                        <!-- ==========================================
                             STEP 1: APPLICANT & HOUSEHOLD
                        =========================================== -->
                        <div class="form-step active" id="step1">
                            <div class="row g-4">
                                <!-- Animal Information (Read Only) -->
                                <div class="col-md-12">
                                    <div class="form-card animal-card bg-light p-3 rounded-3">
                                        <h5 class="fw-bold mb-3"><i class="bi bi-heart-fill text-danger me-2"></i>Animal Information</h5>
                                        <div class="d-flex align-items-center gap-3">
                                            @if($animal->animal_image)
                                                <img src="{{ asset('uploads/animals/' . $animal->animal_image) }}" alt="{{ $animal->name }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <h4 class="mb-1 fw-bold">{{ $animal->name }}</h4>
                                                <p class="mb-0 text-muted">{{ $animal->animal_type }} • {{ $animal->breed ?: 'Unknown' }} • {{ $animal->age ?: 'Unknown' }}</p>
                                                <span class="badge bg-success">For Adoption</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Applicant Information -->
                                <div class="col-md-6">
                                    <div class="form-card h-100">
                                        <div class="card-title mb-3">
                                            <h5 class="fw-bold"><i class="bi bi-person-vcard me-2 text-primary"></i>Applicant Information</h5>
                                        </div>
                                      
@php
    $fullName = trim($user->name ?? '');

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
                                                <input type="email" class="form-control" value="{{ $user->email ?? '' }}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" value="{{ $user->phone ?? '' }}" readonly>
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
                                    </div>
                                </div>

                                <!-- Address & Household -->
                                <div class="col-md-6">
                                    <div class="form-card h-100">
                                        <div class="card-title mb-3">
                                            <h5 class="fw-bold"><i class="bi bi-geo-alt me-2 text-primary"></i>Address & Household</h5>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">House/Unit/Street <span class="text-danger">*</span></label>
                                                <input type="text" name="house_street" class="form-control" value="{{ old('house_street') }}" placeholder="e.g. 123 Mabini St." required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Region <span class="text-danger">*</span></label>
                                                <select name="region" id="region" class="form-select" required>
                                                    <option value="">Select Region</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Province <span class="text-danger">*</span></label>
                                                <select name="province" id="province" class="form-select" required disabled>
                                                    <option value="">Select Province</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">City/Municipality <span class="text-danger">*</span></label>
                                                <select name="city_municipality" id="cityMunicipality" class="form-select" required disabled>
                                                    <option value="">Select City/Municipality</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Barangay <span class="text-danger">*</span></label>
                                                <select name="barangay" id="barangay" class="form-select" required disabled>
                                                    <option value="">Select Barangay</option>
                                                </select>
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

                        <!-- ==========================================
                             STEP 2: BACKGROUND & COMMITMENT
                        =========================================== -->
                        <div class="form-step" id="step2">
                            <div class="row g-4">
                                <!-- Adoption Background -->
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

                                <!-- Adoption Commitment -->
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

                        <!-- ==========================================
                             STEP 3: ID & AGREEMENT
                        =========================================== -->
                        <div class="form-step" id="step3">
                            <div class="row g-4">
                                <!-- ID Upload -->
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

                                <!-- Agreement -->
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

                        <!-- ==========================================
                             STEP 4: REVIEW & SUBMIT
                        =========================================== -->
                        <div class="form-step" id="step4">
                            <div class="text-center mb-4">
                                <h4 class="fw-bold text-success"><i class="bi bi-check-circle-fill me-2"></i>Review Your Application</h4>
                                <p class="text-muted">Please review all the information below before submitting.</p>
                            </div>
                            
                            <div id="reviewContent">
                                <!-- Dynamic Review Content will be injected here by JS -->
                            </div>

                            <div class="alert alert-warning mt-4">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Important Reminder:</strong> Incomplete or false information may result in the rejection of your application.
                            </div>
                        </div>

                    </form>
                </div>

                <!-- Modal Footer (Buttons) -->
                <div class="modal-footer border-0 pt-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </button>
                    <div style="flex: 1;"></div> <!-- Spacer -->
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
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Ito na ang link papunta sa external JS file mo -->
<script src="{{ asset('js/adoption-form.js') }}"></script>

</body>
</html>