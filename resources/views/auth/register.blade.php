<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Register - Animal Rescue PH
    </title>


    <!-- ==================================================
         BOOTSTRAP
         ================================================== -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- ==================================================
         BOOTSTRAP ICONS
         ================================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <!-- ==================================================
         CUSTOM REGISTER CSS
         ================================================== -->

    <link
        rel="stylesheet"
        href="{{ asset('css/register.css') }}"
    >


    <!-- ==================================================
         SMALL HELPER STYLES (READ-HINT & DISABLED STATE)
         ================================================== -->

    <style>

        .read-hint {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            color: #6b7280;
            font-size: 0.85rem;
            margin-top: -6px;
            margin-bottom: 12px;
            font-style: italic;
            line-height: 1.4;
        }

        .read-hint i {
            color: #f59e0b;
            font-size: 1rem;
            margin-top: 1px;
        }

        .terms input[type="checkbox"]:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .terms input[type="checkbox"]:disabled + label {
            color: #9ca3af;
        }

    </style>

</head>


<body>


<div class="register-page">


    <!-- ==================================================
         LEFT SIDE
         ================================================== -->

    <section class="register-left">


        <!-- BACK BUTTON -->

        <button
    type="button"
    class="back-button"
    onclick="history.back()"
>
    <i class="bi bi-arrow-left"></i>
    Back
</button>


        <!-- LOGO -->

        <div class="brand">

            <img
                src="{{ asset('images/logo.png') }}"
                alt="Animal Rescue PH Logo"
            >

            <div>

                <h2>
                    Animal Rescue
                    <span>PH</span>
                </h2>

                <p>
                    Rescue • Rehabilitate • Rehome
                </p>

            </div>

        </div>


        <!-- HERO CONTENT -->

        <div class="hero-content">

            <h1>

                Give Animals a

                <span>
                    Second Chance
                </span>

            </h1>


            <p>

                Create an account and become
                part of Animal Rescue PH.

            </p>


            <div class="hero-message">

                <i class="bi bi-heart-fill"></i>

                <span>
                    Every animal deserves kindness.
                </span>

            </div>

        </div>


    </section>



    <!-- ==================================================
         RIGHT SIDE
         ================================================== -->

    <section class="register-right">


        <div class="register-card">


            <!-- HEADER -->

            <div class="register-header">

                <h1>

                    Create an
                    <span>Account</span>

                </h1>

                <p>
                    Join us and help animals
                </p>

            </div>


            <!-- ==================================================
                 SERVER ERROR MESSAGE
                 ================================================== -->

            @if($errors->any())

                <div class="alert alert-danger">

                    <strong>
                        Please check your information.
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif



            <!-- ==================================================
                 REGISTER FORM
                 ================================================== -->
             @if(session('success'))
    <div class="success-message">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
@endif
            <form
                action="{{ route('register.submit') }}"
                method="POST"
                id="registerForm"
                novalidate
            >

                @csrf


               
<!-- ==================================================
     FULL NAME
     ================================================== -->

<!-- FIRST NAME -->
<div class="input-box">

    <i class="bi bi-person"></i>

    <input
        type="text"
        id="first_name"
        name="first_name"
        value="{{ old('first_name') }}"
        placeholder="First Name"
        maxlength="50"
        autocomplete="given-name"
        required
    >

</div>

<small
    class="input-error"
    id="firstNameError"
></small>


<!-- LAST NAME -->
<div class="input-box">

    <i class="bi bi-person"></i>

    <input
        type="text"
        id="last_name"
        name="last_name"
        value="{{ old('last_name') }}"
        placeholder="Last Name"
        maxlength="50"
        autocomplete="family-name"
        required
    >

</div>

<small
    class="input-error"
    id="lastNameError"
></small>


<!-- HIDDEN FULL NAME -->
<!-- Keeps the existing database/backend field -->
<input
    type="hidden"
    id="name"
    name="name"
    value="{{ old('name') }}"
>

<small
    class="input-error"
    id="nameError"
></small>
<!-- ==================================================
     COMBINED FULL NAME
     This is the value Laravel will receive as "name"
================================================== -->




                <!-- ==================================================
                     EMAIL
                     ================================================== -->

                <div class="input-box">

                    <i class="bi bi-envelope"></i>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email Address"
                        maxlength="255"
                        autocomplete="email"
                        required
                    >

                </div>

                <small
                    class="input-error"
                    id="emailError"
                ></small>



                <!-- ==================================================
                     USERNAME
                     ================================================== -->

                <div class="input-box">

                    <i class="bi bi-person-badge"></i>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Username"
                        minlength="4"
                        maxlength="30"
                        autocomplete="username"
                        required
                    >

                </div>

                <small
                    class="input-error"
                    id="usernameError"
                ></small>



                <!-- ==================================================
                     PHONE
                     ================================================== -->

                <div class="input-box">

                    <i class="bi bi-telephone"></i>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="Phone Number (09XXXXXXXXX)"
                        maxlength="11"
                        inputmode="numeric"
                        autocomplete="tel"
                        required
                    >

                </div>

                <small
                    class="input-error"
                    id="phoneError"
                ></small>



                <!-- ==================================================
                     PASSWORD
                     ================================================== -->

                <div class="input-box">

                    <i class="bi bi-lock"></i>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Password"
                        autocomplete="new-password"
                        required
                    >

                    <button
                        type="button"
                        class="password-button"
                        id="togglePassword"
                    >

                        <i class="bi bi-eye"></i>

                    </button>

                </div>


                <!-- PASSWORD RULES -->

                <div class="password-rules">

                    <p id="lengthRule">

                        <i class="bi bi-circle"></i>

                        At least 8 characters

                    </p>


                    <p id="upperRule">

                        <i class="bi bi-circle"></i>

                        One uppercase letter

                    </p>


                    <p id="lowerRule">

                        <i class="bi bi-circle"></i>

                        One lowercase letter

                    </p>


                    <p id="numberRule">

                        <i class="bi bi-circle"></i>

                        One number

                    </p>

                </div>


                <small
                    class="input-error"
                    id="passwordError"
                ></small>



                <!-- ==================================================
                     CONFIRM PASSWORD
                     ================================================== -->

                <div class="input-box">

                    <i class="bi bi-lock"></i>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirm Password"
                        autocomplete="new-password"
                        required
                    >

                    <button
                        type="button"
                        class="password-button"
                        id="toggleConfirmPassword"
                    >

                        <i class="bi bi-eye"></i>

                    </button>

                </div>

                <small
                    class="input-error"
                    id="confirmPasswordError"
                ></small>



                <!-- ==================================================
                     SINGLE CHECKBOX
                     (Terms + Privacy + Adoption Home Visit Agreement)
                     (DISABLED UNTIL BOTH MODALS READ)
                     ================================================== -->

                <div class="terms">

                    <input
                        type="checkbox"
                        id="terms"
                        name="terms"
                        value="1"
                        required
                        disabled
                        @if(old('terms')) checked @endif
                    >

                    <label for="terms">

                        I agree to the

                        <button
                            type="button"
                            class="terms-link"
                            data-bs-toggle="modal"
                            data-bs-target="#termsModal"
                        >
                            Terms and Conditions
                        </button>

                        and

                        <button
                            type="button"
                            class="terms-link"
                            data-bs-toggle="modal"
                            data-bs-target="#privacyModal"
                        >
                            Privacy Policy
                        </button>,

                        including the
                        <strong>post-adoption home visit and revisit
                        policy</strong> of Animal Rescue PH.

                    </label>

                </div>

                <small
                    class="read-hint"
                    id="termsReadHint"
                >
                    <i class="bi bi-info-circle-fill"></i>
                    <span>
                        Please open and click <strong>"I Understand"</strong>
                        in both the Terms and Privacy Policy first,
                        then you may check this box.
                    </span>
                </small>

                <small
                    class="input-error"
                    id="termsError"
                ></small>



                <!-- ==================================================
                     REGISTER BUTTON
                     ================================================== -->

                <button
                    type="submit"
                    class="register-button"
                >

                    Register

                    <i class="bi bi-arrow-right"></i>

                </button>



                <!-- ==================================================
                     LOGIN LINK
                     ================================================== -->

                <div class="login-section">

                    <span>
                        Already have an account?
                    </span>

                    <a href="{{ route('login') }}">
                        Login here
                    </a>

                </div>


            </form>


        </div>


    </section>


</div>


<!-- =====================================================
     TERMS AND CONDITIONS MODAL
===================================================== -->

<div
    class="modal fade"
    id="termsModal"
    tabindex="-1"
    aria-labelledby="termsModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content auth-modal-content">

            <div class="modal-header auth-modal-header">

                <h5
                    class="modal-title"
                    id="termsModalLabel"
                >
                    <i class="bi bi-file-text-fill"></i>
                    Terms and Conditions
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>

            <div class="modal-body auth-modal-body">

                <p class="auth-modal-intro">
                    Welcome to <strong>Animal Rescue PH</strong>.
                    By creating an account, you agree to the following
                    terms and conditions:
                </p>


                <h6>1. Account Registration</h6>
                <p>
                    You agree to provide accurate, current, and complete
                    information during the registration process and to
                    keep your account information up to date.
                </p>


                <h6>2. Use of the Platform</h6>
                <p>
                    This platform is intended for genuine animal rescue
                    reporting, adoption applications, and coordination
                    with Animal Rescue PH. Any misuse, false reporting,
                    or fraudulent activity may result in account
                    suspension or termination.
                </p>


                <h6>3. Adoption & Reporting</h6>
                <p>
                    Submitting an adoption application or an animal
                    report does not guarantee approval or rescue. All
                    applications and reports are subject to review and
                    verification by our team.
                </p>


                <h6>4. User Conduct</h6>
                <p>
                    You agree to treat other users, our volunteers, and
                    our staff with respect. Any form of harassment,
                    discrimination, or abuse will not be tolerated.
                </p>


                <h6>5. Content Ownership</h6>
                <p>
                    By uploading images, reports, or any content, you
                    confirm that you have the right to share them and
                    grant Animal Rescue PH permission to use them for
                    rescue, adoption, and awareness purposes.
                </p>


                <h6>6. Changes to Terms</h6>
                <p>
                    Animal Rescue PH may update these Terms and
                    Conditions at any time. Continued use of our
                    platform means you accept any changes.
                </p>


                <h6>7. Post-Adoption Home Visits &amp; Revisits</h6>
                <p>
                    By submitting an adoption request, you agree that
                    <strong>Animal Rescue PH</strong> may conduct
                    scheduled or unannounced home visits, follow-up
                    checks, and revisits to the adopter's residence.
                    These visits are conducted to ensure the welfare,
                    safety, and well-being of the adopted animal, and
                    to verify that the adoption conditions are being
                    met. Refusal to allow such visits may result in
                    cancellation or reversal of the adoption.
                </p>

            </div>

            <div class="modal-footer auth-modal-footer">

                <button
                    type="button"
                    class="auth-modal-accept"
                    data-bs-dismiss="modal"
                >
                    <i class="bi bi-check-lg"></i>
                    I Understand
                </button>

            </div>

        </div>

    </div>

</div>


<!-- =====================================================
     PRIVACY POLICY MODAL
===================================================== -->

<div
    class="modal fade"
    id="privacyModal"
    tabindex="-1"
    aria-labelledby="privacyModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content auth-modal-content">

            <div class="modal-header auth-modal-header">

                <h5
                    class="modal-title"
                    id="privacyModalLabel"
                >
                    <i class="bi bi-shield-lock-fill"></i>
                    Privacy Policy
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>

            <div class="modal-body auth-modal-body">

                <p class="auth-modal-intro">
                    Your privacy is important to us. This Privacy Policy
                    explains how <strong>Animal Rescue PH</strong>
                    collects, uses, and protects your personal information.
                </p>


                <h6>1. Information We Collect</h6>
                <p>When you register, we collect the following:</p>
                <ul>
                    <li>Full name (first and last name)</li>
                    <li>Email address (Gmail only)</li>
                    <li>Username</li>
                    <li>Phone number</li>
                    <li>Password (securely hashed)</li>
                </ul>


                <h6>2. How We Use Your Information</h6>
                <p>Your information is used only for:</p>
                <ul>
                    <li>Creating and managing your account</li>
                    <li>Processing adoption applications</li>
                    <li>Verifying animal reports</li>
                    <li>Communicating important updates</li>
                    <li>Internal record-keeping</li>
                </ul>


                <h6>3. Data Protection</h6>
                <p>
                    All personal data is stored securely using
                    industry-standard encryption. Passwords are hashed
                    and never stored in plain text. Only authorized
                    Animal Rescue PH staff can access your data.
                </p>


                <h6>4. Data Sharing</h6>
                <p>
                    We do <strong>not</strong> sell, trade, or rent your
                    personal information to third parties. Your data is
                    only shared when required by law or with your
                    explicit consent.
                </p>


                <h6>5. Data Retention</h6>
                <p>
                    Your information is retained as long as your account
                    is active or as needed for legal and operational
                    purposes. You may request deletion at any time.
                </p>


                <h6>6. Your Rights</h6>
                <p>
                    Under the <strong>Data Privacy Act of 2012
                    (RA 10173)</strong>, you have the right to:
                </p>
                <ul>
                    <li>Access your personal data</li>
                    <li>Correct any inaccurate information</li>
                    <li>Request deletion of your data</li>
                    <li>Object to processing of your data</li>
                </ul>


                <h6>7. Contact Us</h6>
                <p>
                    For privacy concerns, please contact:
                    <br>
                    <strong>Ms. Luzviminda Anne Santos Morales</strong>
                    <br>
                    Phone: <a href="tel:+639234256793">0923 425 6793</a>
                    <br>
                    Facebook:
                    <a
                        href="https://www.facebook.com/animalrescueph/"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        facebook.com/animalrescueph
                    </a>
                </p>

            </div>

            <div class="modal-footer auth-modal-footer">

                <button
                    type="button"
                    class="auth-modal-accept"
                    data-bs-dismiss="modal"
                >
                    <i class="bi bi-check-lg"></i>
                    I Understand
                </button>

            </div>

        </div>

    </div>

</div>


<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


<!-- =====================================================
     READ-TRACKING + FORM VALIDATION SCRIPT
===================================================== -->
<script>

document.addEventListener('DOMContentLoaded', function () {

    var termsCheckbox = document.getElementById('terms');
    var termsReadHint = document.getElementById('termsReadHint');
    var termsModal    = document.getElementById('termsModal');
    var privacyModal  = document.getElementById('privacyModal');

    // Flags to know if the user has read each modal
    var termsRead   = false;
    var privacyRead = false;

    // If the form is reloaded from a failed submission
    // and the terms checkbox was previously checked,
    // treat as already-read (avoid forcing them to re-read).
    if (termsCheckbox && termsCheckbox.checked) {
        termsRead   = true;
        privacyRead = true;
    }

    function updateTermsState() {

        if (!termsCheckbox) {
            return;
        }

        if (termsRead && privacyRead) {

            termsCheckbox.disabled = false;

            if (termsReadHint) {
                termsReadHint.style.display = 'none';
            }
        }
    }

    // Apply on page load (in case of old('terms') reload)
    updateTermsState();


    // ---- Track "I Understand" clicks in Terms modal ----
    if (termsModal) {
        termsModal.addEventListener('click', function (event) {

            if (event.target.closest('.auth-modal-accept')) {
                termsRead = true;
                updateTermsState();
            }
        });
    }


    // ---- Track "I Understand" clicks in Privacy modal ----
    if (privacyModal) {
        privacyModal.addEventListener('click', function (event) {

            if (event.target.closest('.auth-modal-accept')) {
                privacyRead = true;
                updateTermsState();
            }
        });
    }

});

</script>


<!-- Register JS (loaded after our script so it can't override our validation) -->
<script src="{{ asset('js/register.js') }}"></script>

</body>

</html>