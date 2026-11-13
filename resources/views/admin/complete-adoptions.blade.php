<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Complete Adoption | Animal Rescue PH</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/complete-adoptions.css') }}">
</head>
<body>

@php
    $monitoringByWeek = collect($monitorings ?? [])->keyBy('week_number');
    $completedWeeks = $monitoringByWeek->where('status', 'Completed')->count();
    $allWeeksCompleted = $completedWeeks === 4;
@endphp

<div class="complete-page">
    <div class="page-container">

        <div class="top-navigation">
            <a href="{{ route('admin.manage-adoptions') }}" class="back-button">
                <i class="bi bi-arrow-left"></i>
                Back to Manage Adoptions
            </a>

            <div class="brand">
                <div class="brand-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Animal Rescue PH">
                </div>
                <div>
                    <span class="brand-name">Animal Rescue PH</span>
                    <span class="brand-subtitle">Animal Rescue & Adoption</span>
                </div>
            </div>
        </div>

        <div class="page-title">
            <div class="page-title-icon"><i class="bi bi-heart-fill"></i></div>
            <div>
                <span class="page-label">ADOPTION FINALIZATION & MONITORING</span>
                <h1>Complete Adoption</h1>
                <p>Review the approved application, record the four weekly post-adoption checks, and finalize the adoption only after the monitoring process is complete.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-box alert-success-custom">
                <i class="bi bi-check-circle-fill"></i>
                <div><strong>Success</strong><p>{{ session('success') }}</p></div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-box alert-error-custom">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div><strong>Unable to continue</strong><p>{{ session('error') }}</p></div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert-box alert-error-custom">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>
                    <strong>Please check the following:</strong>
                    <ul class="validation-list">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            </div>
        @endif

        <section class="application-card">
            <div class="application-header">
                <div>
                    <span class="application-number">Application #{{ $application->id }}</span>
                    <h2>{{ $application->first_name ?? '' }} {{ $application->last_name ?? '' }}</h2>
                    <p>Approved adoption application</p>
                </div>
                <span class="approved-badge"><i class="bi bi-check-circle-fill"></i> Approved</span>
            </div>

            <div class="communication-notice">
                <div class="notice-icon"><i class="bi bi-chat-heart-fill"></i></div>
                <div>
                    <h3>Post-adoption monitoring</h3>
                    <p>This page is used after approval to record the adopter's weekly follow-up checks. Completing a weekly check does not change the adoption status. The adoption becomes <strong>Completed</strong> and the animal becomes <strong>Adopted</strong> only when the final Complete Adoption button is submitted.</p>
                </div>
            </div>

            <section class="information-section">
                <div class="section-heading"><div class="section-icon"><i class="bi bi-person-fill"></i></div><div><h3>Applicant Information</h3><p>Information submitted by the adopter.</p></div></div>
                <div class="information-grid">
                    <div class="information-item"><span>Full Name</span><strong>{{ trim(($application->first_name ?? '').' '.($application->last_name ?? '')) ?: '—' }}</strong></div>
                    <div class="information-item"><span>Email Address</span><strong>{{ $application->email ?? '—' }}</strong></div>
                    <div class="information-item"><span>Contact Number</span><strong>{{ $application->contact_number ?? '—' }}</strong></div>
                    <div class="information-item"><span>Occupation</span><strong>{{ $application->occupation ?? '—' }}</strong></div>
                    <div class="information-item"><span>Civil Status</span><strong>{{ $application->civil_status ?? '—' }}</strong></div>
                </div>
            </section>

            <section class="information-section">
                <div class="section-heading"><div class="section-icon"><i class="bi bi-heart-fill"></i></div><div><h3>Animal Information</h3><p>Animal assigned to this approved adoption application.</p></div></div>
                @if($application->animal)
                    @php $animalImage = $application->animal->animal_image ?? $application->animal->image ?? null; @endphp
                    <div class="animal-information">
                        <div class="animal-image-container">
                            @if($animalImage)
                                <img src="{{ asset('uploads/animals/'.$animalImage) }}" alt="{{ $application->animal->name }}" class="animal-image">
                            @else
                                <div class="animal-placeholder"><i class="bi bi-image"></i><span>No Image Available</span></div>
                            @endif
                        </div>
                        <div class="animal-detail-grid">
                            <div class="information-item"><span>Animal Name</span><strong>{{ $application->animal->name ?? '—' }}</strong></div>
                            <div class="information-item"><span>Animal Type</span><strong>{{ $application->animal->animal_type ?? '—' }}</strong></div>
                            <div class="information-item"><span>Breed</span><strong>{{ $application->animal->breed ?? '—' }}</strong></div>
                            <div class="information-item"><span>Gender</span><strong>{{ $application->animal->gender ?? '—' }}</strong></div>
                            <div class="information-item"><span>Age</span><strong>{{ $application->animal->age ?? '—' }}</strong></div>
                            <div class="information-item"><span>Current Animal Status</span><strong>{{ $application->animal->status ?? '—' }}</strong></div>
                        </div>
                    </div>
                @else
                    <div class="warning-box"><i class="bi bi-exclamation-triangle"></i> Animal information is unavailable.</div>
                @endif
            </section>

            <section class="information-section">
                <div class="section-heading"><div class="section-icon"><i class="bi bi-geo-alt-fill"></i></div><div><h3>Adoption Address</h3><p>Residence information provided by the applicant.</p></div></div>
                <div class="information-grid">
                    <div class="information-item full-width"><span>House / Unit / Street</span><strong>{{ $application->house_street ?? '—' }}</strong></div>
                    <div class="information-item"><span>Region</span><strong>{{ $application->region ?? '—' }}</strong></div>
                    <div class="information-item"><span>Province</span><strong>{{ $application->province ?? '—' }}</strong></div>
                    <div class="information-item"><span>City / Municipality</span><strong>{{ $application->city_municipality ?? '—' }}</strong></div>
                    <div class="information-item"><span>Barangay</span><strong>{{ $application->barangay ?? '—' }}</strong></div>
                </div>
            </section>

            <section class="information-section">
                <div class="section-heading"><div class="section-icon"><i class="bi bi-house-heart-fill"></i></div><div><h3>Adoption Information</h3><p>Assessment information submitted with the application.</p></div></div>
                <div class="information-grid">
                    <div class="information-item full-width"><span>Reason for Adoption</span><strong>{{ $application->reason_for_adoption ?? '—' }}</strong></div>
                    <div class="information-item full-width"><span>Explanation</span><strong class="long-value">{{ $application->reason_explanation ?? '—' }}</strong></div>
                    <div class="information-item"><span>Primary Responsible Person</span><strong>{{ $application->primary_responsible ?? '—' }}@if($application->primary_responsible === 'Other' && $application->primary_responsible_other)<br><small>{{ $application->primary_responsible_other }}</small>@endif</strong></div>
                    <div class="information-item"><span>Residence Type</span><strong>{{ $application->residence_type ?? '—' }}@if($application->residence_type === 'Other' && $application->residence_other)<br><small>{{ $application->residence_other }}</small>@endif</strong></div>
                    <div class="information-item"><span>Household Members</span><strong>{{ $application->household_members ?? '—' }}</strong></div>
                    <div class="information-item"><span>Household Support</span><strong>{{ $application->household_support ?? '—' }}</strong></div>
                </div>
            </section>

            <section class="information-section">
                <div class="section-heading"><div class="section-icon"><i class="bi bi-person-vcard-fill"></i></div><div><h3>Valid ID Verification</h3><p>Identification document submitted with the application.</p></div></div>
                <div class="valid-id-card">
                    <div class="valid-id-icon"><i class="bi bi-card-image"></i></div>
                    <div class="valid-id-information"><span>Submitted ID</span><strong>{{ $application->valid_id_original_name ?? 'Valid ID' }}</strong><small>Verification Status: <b>{{ ucfirst($application->id_verification_status ?? 'Pending') }}</b></small></div>
                    @if($application->valid_id_path)
                        <a href="{{ route('admin.adoption.valid-id', $application->id) }}" target="_blank" rel="noopener noreferrer" class="view-id-button"><i class="bi bi-eye-fill"></i> View Valid ID</a>
                    @else
                        <span class="text-muted small">No valid ID uploaded.</span>
                    @endif
                </div>
            </section>

            <section class="monitoring-section" id="weekly-monitoring">
                <div class="monitoring-heading">
                    <div>
                        <span class="monitoring-label">POST-ADOPTION FOLLOW-UP</span>
                        <h3>Weekly Monitoring — 4 Weeks</h3>
                        <p>Record one follow-up check for each week. All four weeks must be completed before the adoption can be finalized.</p>
                    </div>
                    <div class="monitoring-progress"><strong>{{ $completedWeeks }}/4</strong><span>Weeks Completed</span></div>
                </div>

                <div class="week-grid">
                    @foreach([1,2,3,4] as $week)
                        @php
                            $monitor = $monitoringByWeek->get($week);
                            $isCompleted = $monitor && $monitor->status === 'Completed';
                        @endphp
                        <article class="week-card {{ $isCompleted ? 'week-completed' : '' }}">
                            <div class="week-card-header">
                                <div class="week-number"><span>WEEK</span><strong>{{ $week }}</strong></div>
                                <span class="week-status {{ $isCompleted ? 'completed' : 'pending' }}">
                                    <i class="bi {{ $isCompleted ? 'bi-check-circle-fill' : 'bi-clock-fill' }}"></i>
                                    {{ $isCompleted ? 'Completed' : 'Pending' }}
                                </span>
                            </div>

                            <form method="POST" action="{{ route('admin.adoptions.monitoring.save', $application->id) }}" class="week-form">
                                @csrf
                                <input type="hidden" name="week_number" value="{{ $week }}">

                                <div class="form-group">
                                    <label for="monitoring_date_{{ $week }}">Monitoring Date</label>
                                    <input type="date" id="monitoring_date_{{ $week }}" name="monitoring_date" value="{{ optional($monitor?->monitoring_date)->format('Y-m-d') ?? now()->format('Y-m-d') }}" required>
                                </div>

                                <div class="check-list">
                                    @foreach([
                                        'animal_condition' => 'Animal is safe and in good condition.',
                                        'food_water' => 'Food and clean water are being provided.',
                                        'shelter_condition' => 'The animal has proper and safe shelter.',
                                        'care_compliance' => 'The adopter is following the agreed care responsibilities.'
                                    ] as $field => $label)
                                        <label class="monitor-check">
                                            <input type="checkbox" name="{{ $field }}" value="1" {{ old($field, $monitor?->$field) ? 'checked' : '' }}>
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="form-group">
                                    <label for="notes_{{ $week }}">Monitoring Notes</label>
                                    <textarea id="notes_{{ $week }}" name="notes" rows="4" maxlength="2000" placeholder="Write observations, concerns, or follow-up notes...">{{ old('notes', $monitor?->notes) }}</textarea>
                                </div>

                                <button type="submit" class="save-week-button">
                                    <i class="bi bi-check2-circle"></i>
                                    {{ $isCompleted ? 'Update Week '.$week.' Check' : 'Save Week '.$week.' Check' }}
                                </button>
                            </form>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="final-review {{ $allWeeksCompleted ? 'ready' : 'not-ready' }}">
                <div class="final-review-icon"><i class="bi {{ $allWeeksCompleted ? 'bi-shield-check' : 'bi-lock-fill' }}"></i></div>
                <div class="final-review-content">
                    <span class="final-review-label">FINAL ADOPTION STATUS</span>
                    <h3>{{ $allWeeksCompleted ? 'All weekly monitoring checks are complete.' : 'Weekly monitoring is not yet complete.' }}</h3>
                    <p>{{ $allWeeksCompleted ? 'The adoption is ready for final confirmation. Submitting the button below will mark the application as Completed and the animal as Adopted.' : 'Complete Week 1, Week 2, Week 3, and Week 4 monitoring before finalizing the adoption.' }}</p>
                    <div class="completion-summary">
                        <span><i class="bi bi-check-circle-fill"></i> Applicant reviewed</span>
                        <span><i class="bi bi-check-circle-fill"></i> Animal reviewed</span>
                        <span class="{{ $allWeeksCompleted ? 'done' : '' }}"><i class="bi {{ $allWeeksCompleted ? 'bi-check-circle-fill' : 'bi-clock-fill' }}"></i> 4 weekly checks completed</span>
                    </div>
                </div>
            </section>

            <div class="bottom-actions">
                <a href="{{ route('admin.manage-adoptions') }}" class="back-action"><i class="bi bi-arrow-left"></i> Back to Manage Adoptions</a>

                <form id="completeAdoptionForm" action="{{ route('admin.adoptions.complete', $application->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" id="completeButton" class="complete-button" {{ $allWeeksCompleted ? '' : 'disabled' }}>
                        <span id="completeButtonIcon"><i class="bi bi-check2-circle"></i></span>
                        <span id="completeButtonText">{{ $allWeeksCompleted ? 'Complete Adoption' : 'Complete All Weekly Checks First' }}</span>
                    </button>
                </form>
            </div>
        </section>

        <div class="page-footer"><i class="bi bi-shield-check"></i> Animal Rescue PH — Adoption Management System</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/admin/complete-adoptions.js') }}"></script>
</body>
</html>
