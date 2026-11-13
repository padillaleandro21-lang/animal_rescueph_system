<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        About Us | Animal Rescue PH
    </title>

    {{-- Bootstrap --}}
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
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >

    {{-- Home CSS (header/footer) --}}
    <link
        rel="stylesheet"
        href="{{ asset('css/home.css') }}"
    >

    {{-- About Us CSS --}}
    <link
        rel="stylesheet"
        href="{{ asset('css/about.css') }}"
    >

</head>


<body>


{{-- =====================================================
     ORG INFO
====================================================== --}}
@php

    $org = [
        'name'          => 'Animal Rescue PH',
        'current_city'  => 'San Miguel, Bulacan',
        'origin'        => 'Metro Manila',

        'contact_name'  => 'Ms. Luzviminda Anne Santos Morales',
        'contact_phone' => '0923 425 6793',
        'contact_tel'   => '+639234256793',

        'socials' => [
            [
                'name'  => 'Facebook',
                'icon'  => 'bi-facebook',
                'url'   => 'https://www.facebook.com/animalrescueph/',
                'handle'=> '@animalrescueph',
                'color' => '#1877f2',
            ],
            [
                'name'  => 'Messenger',
                'icon'  => 'bi-messenger',
                'url'   => 'https://m.me/animalrescueph',
                'handle'=> '@animalrescueph',
                'color' => '#0084ff',
            ],
            [
                'name'  => 'Instagram',
                'icon'  => 'bi-instagram',
                'url'   => 'https://www.instagram.com/animalrescueph',
                'handle'=> '@animalrescueph',
                'color' => '#e1306c',
            ],
            [
                'name'  => 'TikTok',
                'icon'  => 'bi-tiktok',
                'url'   => 'https://www.tiktok.com/@animalrescueph',
                'handle'=> '@animalrescueph',
                'color' => '#000000',
            ],
            [
                'name'  => 'Threads',
                'icon'  => 'bi-threads',
                'url'   => 'https://www.threads.net/@animalrescue_ph',
                'handle'=> '@animalrescue_ph',
                'color' => '#000000',
            ],
            [
                'name'  => 'X (Twitter)',
                'icon'  => 'bi-twitter-x',
                'url'   => 'https://x.com/animalrescueph1924',
                'handle'=> '@animalrescueph1924',
                'color' => '#000000',
            ],
            [
                'name'  => 'YouTube',
                'icon'  => 'bi-youtube',
                'url'   => 'https://www.youtube.com/@animalrescueph',
                'handle'=> '@animalrescueph',
                'color' => '#ff0000',
            ],
        ],
    ];

    $stats = [
        [
            'icon'  => 'bi-heart-pulse-fill',
            'value' => '500+',
            'label' => 'Animals Rescued',
        ],
        [
            'icon'  => 'bi-house-heart-fill',
            'value' => '350+',
            'label' => 'Adopted to Families',
        ],
        [
            'icon'  => 'bi-people-fill',
            'value' => '50+',
            'label' => 'Active Volunteers',
        ],
        [
            'icon'  => 'bi-geo-alt-fill',
            'value' => 'Bulacan',
            'label' => 'Based in San Miguel',
        ],
    ];

@endphp


<!-- =====================================================
     HEADER
===================================================== -->

<header class="main-header">

    <div class="header-container">

        {{-- LOGO --}}
        <div class="logo-section">

            <div class="logo-icon">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Animal Rescue PH Logo"
                >

            </div>

            <div class="logo-text">

                <h1 class="logo-title">
                    Animal Rescue <span>PH</span>
                </h1>

            </div>

        </div>


        {{-- HAMBURGER --}}
        <button
            class="hamburger-button"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavigation"
            aria-controls="mainNavigation"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >

            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>

        </button>


        {{-- NAVIGATION --}}
        <nav
            class="navigation-menu collapse"
            id="mainNavigation"
        >

            <a href="{{ route('home') }}" class="nav-link">
                Home
            </a>

            <a href="{{ route('report-animal') }}" class="nav-link">
                Report Animal
            </a>

            <a href="{{ route('adoption') }}" class="nav-link">
                Adoption
            </a>

            <a href="{{ route('about') }}" class="nav-link active">
                About Us
            </a>

        </nav>


        {{-- LOGIN / REGISTER / USER --}}
        <div class="header-buttons">

            @auth

                <div class="user-account">

                    <button
                        type="button"
                        class="user-account-button"
                        id="userAccountButton"
                        aria-expanded="false"
                    >

                        <span class="user-account-icon">
                            <i class="bi bi-person"></i>
                        </span>

                        <span class="user-account-name">
                            {{ auth()->user()->name }}
                        </span>

                        <i class="bi bi-chevron-down user-account-arrow"></i>

                    </button>


                    <div
                        class="user-information-dropdown"
                        id="userInformationDropdown"
                    >

                        <div class="user-dropdown-header">

                            <div class="user-dropdown-avatar">
                                <i class="bi bi-person"></i>
                            </div>

                            <div class="user-dropdown-name">

                                <h5>{{ auth()->user()->name }}</h5>
                                <span>{{ auth()->user()->email }}</span>

                            </div>

                        </div>


                        <div class="user-details">

                            <div class="user-detail-item">
                                <i class="bi bi-person"></i>
                                <div>
                                    <small>Full Name</small>
                                    <strong>{{ auth()->user()->name }}</strong>
                                </div>
                            </div>

                            <div class="user-detail-item">
                                <i class="bi bi-envelope"></i>
                                <div>
                                    <small>Email Address</small>
                                    <strong>{{ auth()->user()->email }}</strong>
                                </div>
                            </div>

                            <div class="user-detail-item">
                                <i class="bi bi-person-badge"></i>
                                <div>
                                    <small>Username</small>
                                    <strong>{{ auth()->user()->username ?? 'Not provided' }}</strong>
                                </div>
                            </div>

                            <div class="user-detail-item">
                                <i class="bi bi-telephone"></i>
                                <div>
                                    <small>Phone Number</small>
                                    <strong>{{ auth()->user()->phone ?? 'Not provided' }}</strong>
                                </div>
                            </div>

                        </div>


                        <div class="user-dropdown-logout">

                            <form action="{{ route('logout') }}" method="POST">

                                @csrf

                                <button type="submit" class="user-logout-button">

                                    <i class="bi bi-box-arrow-right"></i>
                                    Logout

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @else

                <a href="{{ route('login') }}" class="login-button">
                    Login
                </a>

                <a href="{{ route('register') }}" class="register-button">
                    Register
                </a>

            @endauth

        </div>

    </div>

</header>


<!-- =====================================================
     ABOUT PAGE
===================================================== -->

<main class="about-page">


    {{-- ============================================
         HERO
    ============================================= --}}
    <section class="about-hero">

        <div class="about-hero-overlay"></div>

        <div class="about-hero-content">

            <span class="about-hero-kicker">
                <i class="bi bi-heart-fill"></i>
                ABOUT ANIMAL RESCUE PH
            </span>

            <h1>
                A Safe Haven for the <br>
                <span>Abused, Injured, and Neglected</span>
            </h1>

            <p>
                An independent animal rescue organization based in
                San Miguel, Bulacan — with roots in the rescue
                community of Metro Manila. We rescue, care for, and
                rehome animals in need.
            </p>

        </div>

    </section>


    {{-- ============================================
         STATS
    ============================================= --}}
    <section class="about-stats-section">

        <div class="about-stats-grid">

            @foreach($stats as $stat)

                <div class="about-stat">

                    <div class="about-stat-icon">
                        <i class="bi {{ $stat['icon'] }}"></i>
                    </div>

                    <strong>{{ $stat['value'] }}</strong>
                    <span>{{ $stat['label'] }}</span>

                </div>

            @endforeach

        </div>

    </section>


    {{-- ============================================
         MISSION & VISION
    ============================================= --}}
    <section class="about-mv-section">

        <div class="about-mv-grid">


            {{-- MISSION --}}
            <div class="about-mv-card mission-card">

                <div class="about-mv-icon">
                    <i class="bi bi-bullseye"></i>
                </div>

                <h2>Our Mission</h2>

                <p>
                    Animal Rescue PH is the initiative of an independent
                    group of volunteers who aim to foster a safe and
                    nurturing environment for abused, injured, and
                    neglected animals.
                </p>

                <p>
                    We campaign against animal cruelty and take action
                    to rescue and provide food and shelter to the poor
                    victims of this injustice. With kindness and
                    compassion, we believe that anyone can help make
                    our neighborhood a safe haven for these lovely
                    animals.
                </p>

            </div>


            {{-- VISION --}}
            <div class="about-mv-card vision-card">

                <div class="about-mv-icon">
                    <i class="bi bi-eye-fill"></i>
                </div>

                <h2>Our Vision</h2>

                <p>
                    A Philippines where every animal is treated with
                    kindness, compassion, and dignity — where no animal
                    is left to suffer on the streets, and where every
                    community becomes a safe haven for animals in need.
                </p>

                <p>
                    From our origins in Metro Manila to our current
                    home in San Miguel, Bulacan, we continue to
                    grow this advocacy nationwide.
                </p>

            </div>

        </div>

    </section>


    {{-- ============================================
         OUR STORY
    ============================================= --}}
    <section class="about-story-section">

        <div class="about-story-layout">

            <div class="about-story-image">

                <img
                    src="{{ asset('images/ph dogs.png') }}"
                    alt="Animal Rescue PH Story"
                   
                >

            </div>


            <div class="about-story-content">

                <span class="about-section-kicker">
                    OUR STORY
                </span>

                <h2>
                    From Metro Manila <br>
                    to San Miguel, Bulacan
                </h2>

                <p>
                    Animal Rescue PH is an independent animal rescue
                    organization in the Philippines. Beginning from
                    the rescue community in <strong>Metro Manila</strong>,
                    our group of volunteers set out to rescue
                    maltreated animals encountered along the streets
                    and provide them with proper food, shelter, and
                    care.
                </p>

                <p>
                    Today, we are based in <strong>San Miguel, Bulacan</strong>,
                    where we continue our advocacy for animal welfare
                    and expand our rescue operations to serve more
                    communities in need.
                </p>

                <div class="about-story-highlights">

                    <div class="about-highlight">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Origins in Metro Manila</span>
                    </div>

                    <div class="about-highlight">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Now based in San Miguel, Bulacan</span>
                    </div>

                    <div class="about-highlight">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>100% volunteer-driven</span>
                    </div>

                    <div class="about-highlight">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Against animal cruelty &amp; neglect</span>
                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- ============================================
         WHO WE ARE
    ============================================= --}}
    <section class="about-team-section">

        <div class="about-section-header">

            <span class="about-section-kicker">
                WHO WE ARE
            </span>

            <h2>
                An Independent Group of <span>Volunteers</span>
            </h2>

            <p>
                We are animal lovers and independent rescuers —
                united by a common purpose: to give abandoned and
                abused animals a second chance at life.
            </p>

        </div>


        <div class="about-org-grid">

            <div class="org-card">

                <div class="org-icon">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>

                <h3>Rescue Volunteers</h3>

                <p>
                    On-the-ground responders who rescue maltreated,
                    injured, and abandoned animals found along the
                    streets of our community.
                </p>

            </div>


            <div class="org-card">

                <div class="org-icon">
                    <i class="bi bi-house-heart-fill"></i>
                </div>

                <h3>Foster &amp; Care</h3>

                <p>
                    Compassionate families who temporarily open their
                    homes and provide love, food, and shelter to
                    rescued animals in need.
                </p>

            </div>


            <div class="org-card">

                <div class="org-icon">
                    <i class="bi bi-shield-fill-check"></i>
                </div>

                <h3>Animal Welfare Advocates</h3>

                <p>
                    Advocates who campaign against animal cruelty and
                    promote responsible pet ownership across our
                    communities.
                </p>

            </div>


            <div class="org-card">

                <div class="org-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <h3>Community Supporters</h3>

                <p>
                    Neighbors and friends who donate pet food,
                    medicine, and resources that keep our rescue
                    missions going.
                </p>

            </div>

        </div>

    </section>


    {{-- ============================================
         HOW YOU CAN HELP
    ============================================= --}}
    <section class="about-values-section">

        <div class="about-section-header">

            <span class="about-section-kicker">
                HOW YOU CAN HELP
            </span>

            <h2>
                Every Bit of <span>Kindness Counts</span>
            </h2>

            <p>
                We welcome any form of support for the welfare of
                rescued animals.
            </p>

        </div>


        <div class="about-values-grid">

            <div class="value-card">

                <div class="value-icon">
                    <i class="bi bi-bag-heart-fill"></i>
                </div>

                <h3>Donate in Kind</h3>

                <p>
                    Dog and cat food, medicine, towels, cages, and
                    other supplies are always needed by our rescued
                    animals.
                </p>

            </div>


            <div class="value-card">

                <div class="value-icon">
                    <i class="bi bi-cash-coin"></i>
                </div>

                <h3>Monetary Support</h3>

                <p>
                    Financial donations help cover veterinary bills,
                    food, and shelter costs for animals under our
                    care.
                </p>

            </div>


            <div class="value-card">

                <div class="value-icon">
                    <i class="bi bi-hand-thumbs-up-fill"></i>
                </div>

                <h3>Volunteer With Us</h3>

                <p>
                    Join our rescue missions, foster a rescued animal,
                    or help spread the word about animal welfare.
                </p>

            </div>


            <div class="value-card">

                <div class="value-icon">
                    <i class="bi bi-heart-fill"></i>
                </div>

                <h3>Adopt a Pet</h3>

                <p>
                    Give a rescued animal a forever home. Every
                    adoption opens space for us to rescue another
                    animal in need.
                </p>

            </div>

        </div>

    </section>


    {{-- ============================================
         FOLLOW US — SOCIAL MEDIA
    ============================================= --}}
    <section class="about-social-section">

        <div class="about-section-header">

            <span class="about-section-kicker">
                FOLLOW US
            </span>

            <h2>
                Connect With <span>Animal Rescue PH</span>
            </h2>

            <p>
                Follow us on social media for rescue updates,
                adoption stories, and events near you.
            </p>

        </div>


        <div class="about-social-grid">

            @foreach($org['socials'] as $social)

                <a
                    href="{{ $social['url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="social-card"
                    style="--social-color: {{ $social['color'] }};"
                    title="Follow us on {{ $social['name'] }}"
                >

                    <div class="social-icon">
                        <i class="bi {{ $social['icon'] }}"></i>
                    </div>

                    <div class="social-info">

                        <strong>{{ $social['name'] }}</strong>

                        <span>{{ $social['handle'] }}</span>

                    </div>

                    <i class="bi bi-arrow-up-right social-arrow"></i>

                </a>

            @endforeach

        </div>

    </section>


    {{-- ============================================
         CONTACT INFO
    ============================================= --}}
    <section class="about-contact-section">

        <div class="about-section-header">

            <span class="about-section-kicker">
                GET IN TOUCH
            </span>

            <h2>
                Contact <span>{{ $org['name'] }}</span>
            </h2>

            <p>
                For any concerns and inquiries, please reach out to us.
            </p>

        </div>


        <div class="about-contact-grid">


            {{-- LOCATION --}}
            <div class="about-contact-card">

                <div class="about-contact-icon">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>

                <h3>Our Location</h3>

                <p>
                    <strong>{{ $org['current_city'] }}</strong><br>
                    Philippines
                </p>

                <p class="about-contact-note">
                    Origins in {{ $org['origin'] }}
                </p>

            </div>


            {{-- PHONE --}}
            <div class="about-contact-card">

                <div class="about-contact-icon">
                    <i class="bi bi-telephone-fill"></i>
                </div>

                <h3>Call or Text</h3>

                <p>
                    {{ $org['contact_name'] }}<br>
                    <a href="tel:{{ $org['contact_tel'] }}">
                        {{ $org['contact_phone'] }}
                    </a>
                </p>

            </div>


            {{-- FACEBOOK --}}
            <div class="about-contact-card">

                <div class="about-contact-icon">
                    <i class="bi bi-facebook"></i>
                </div>

                <h3>Facebook</h3>

                <p>
                    <a
                        href="https://www.facebook.com/animalrescueph/"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        facebook.com/animalrescueph
                    </a>
                </p>

                <p class="about-contact-note">
                    Message us for rescue inquiries.
                </p>

            </div>


        </div>

    </section>


</main>


<!-- =====================================================
     FOOTER
===================================================== -->

<footer class="main-footer">

    <p>
        © 2026 Animal Rescue PH. All Rights Reserved.
    </p>

</footer>


{{-- Bootstrap --}}
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

{{-- Header JS --}}
<script src="{{ asset('js/home.js') }}"></script>

{{-- About JS (scroll reveal lang) --}}
<script src="{{ asset('js/about.js') }}"></script>

</body>

</html>