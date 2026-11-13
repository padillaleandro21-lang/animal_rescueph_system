<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Forgot Password | Animal Rescue PH</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/login.css') }}"
    >

</head>

<body>

<button
    type="button"
    class="back-button"
    onclick="history.back()"
>
    <i class="bi bi-arrow-left"></i>
    Back
</button>


<div class="login-container">

    {{-- LEFT SIDE --}}
    <div class="login-left">

        <div class="brand">

            <div class="logo-icon">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Animal Rescue PH Logo"
                >

            </div>

            <div>

                <h1>
                    ANIMAL RESCUE <span>PH</span>
                </h1>

                <p>Rescue • Rehabilitate • Rehome</p>

            </div>

        </div>


        <div class="rescue-message">

            <h2>
                Reset Your
                <br>
                Password
            </h2>

            <p>
                We'll send a 6-digit OTP code to your
                registered email address.
            </p>

        </div>


        <div class="animal-image">

            <img
                src="{{ asset('images/dogy and caty.png') }}"
                alt="Animal Rescue PH"
            >

        </div>

    </div>


    {{-- RIGHT SIDE --}}
    <div class="login-right">

        <div class="login-form-container">

            <h2>Forgot Password?</h2>

            <p class="login-subtitle">
                Enter your email to receive an OTP code
            </p>


            @if(session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            @if($errors->any())

                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>

            @endif


            <form
                action="{{ route('password.email') }}"
                method="POST"
            >

                @csrf

                <div class="input-group-custom">

                    <i class="bi bi-envelope"></i>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        placeholder="Email Address"
                        autocomplete="email"
                        required
                        autofocus
                    >

                </div>


                <button
                    type="submit"
                    class="login-button"
                >

                    Send OTP Code

                    <i class="bi bi-shield-lock-fill"></i>

                </button>

            </form>


            <p class="register-text">

                Remembered your password?

                <a href="{{ route('login') }}">
                    Back to Login
                </a>

            </p>

        </div>

    </div>

</div>

</body>

</html>