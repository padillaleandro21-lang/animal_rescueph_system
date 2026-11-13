<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login | Animal Rescue PH</title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Bootstrap Icons -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <!-- Custom Login CSS -->

    <link
        rel="stylesheet"
        href="{{ asset('css/login.css') }}"
    >

</head>


<body>


<!-- =====================================================
     BACK BUTTON
====================================================== -->

<button
    type="button"
    class="back-button"
    onclick="history.back()"
>
    <i class="bi bi-arrow-left"></i>
    Back
</button>


<!-- =====================================================
     LOGIN CONTAINER
====================================================== -->

<div class="login-container">


    <!-- =================================================
         LEFT SIDE
    ================================================== -->

    <div class="login-left">


        <!-- LOGO -->

        <div class="brand">

           <div class="logo-icon">

        <img
            src="{{ asset('images/logo.png') }}"
            alt="Animal Rescue PH Logo"
        >

    </div>


            <div>

                <h1>
                    ANIMAL RESCUE
                    <span>PH</span>
                </h1>

                <p>
                    Rescue • Rehabilitate • Rehome
                </p>

            </div>

        </div>



        <!-- MESSAGE -->

        <div class="rescue-message">

            <h2>
                A Safer Tomorrow
                <br>
                For Every Animal
            </h2>

            <p>
                Every rescue gives an animal
                another chance for a better life.
            </p>

        </div>



        <!-- SIMPLE ANIMAL IMAGE -->

        <div class="animal-image">

            <img
                src="{{ asset('images/dogy and caty.png') }}"
                alt="Animal Rescue PH"
            >

        </div>


    </div>



    <!-- =================================================
         RIGHT SIDE
    ================================================== -->

    <div class="login-right">


        <div class="login-form-container">


            <h2>
                Welcome Back!
            </h2>

            <p class="login-subtitle">
                Login to your account
            </p>



            <!-- SUCCESS MESSAGE -->

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif



            <!-- ERROR MESSAGE -->

            @if($errors->any())

                <div class="alert alert-danger">

                    {{ $errors->first() }}

                </div>

            @endif



            <!-- =================================================
                 LOGIN FORM
            ================================================== -->

            <form
                action="{{ route('login.submit') }}"
                method="POST"
            >

                @csrf


                <!-- EMAIL -->

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
                    >

                </div>



                <!-- PASSWORD -->

                <div class="input-group-custom">

                    <i class="bi bi-lock"></i>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Password"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        id="passwordToggle"
                    >

                        <i
                            class="bi bi-eye-slash"
                            id="passwordIcon"
                        ></i>

                    </button>

                </div>



                <!-- OPTIONS -->

                <div class="login-options">

                    <label>

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                        >

                        Remember me

                    </label>


                    <a href="{{ route('password.request') }}">
    Forgot Password?
</a>


                <!-- LOGIN BUTTON -->

                <button
                    type="submit"
                    class="login-button"
                >

                    Login

                    <i class="bi bi-arrow-right"></i>

                </button>

            </form>



            <!-- =================================================
                 DIVIDER
            ================================================== -->
            <!-- REGISTER -->

            <p class="register-text">

                Don't have an account?

                <a href="{{ route('register') }}">
                    Register here
                </a>

            </p>


        </div>

    </div>

</div>



<!-- JavaScript -->

<script src="{{ asset('js/login.js') }}"></script>


</body>

</html>