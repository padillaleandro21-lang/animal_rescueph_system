<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard </title>

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
>
    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
>

    <!-- Bootstrap Icons -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <!-- Dashboard CSS -->

    <link
        rel="stylesheet"
        href="{{ asset('css/admin-dashboard.css') }}"
    >

</head>


<body>


<div class="dashboard-wrapper">


    <!-- =====================================================
         SIDEBAR
    ====================================================== -->

    <aside class="sidebar">


        <!-- LOGO -->

        <div class="sidebar-logo">

            <img
                src="{{ asset('images/logo.png') }}"
                alt="Animal Rescue PH"
            >

        </div>


        <!-- ORGANIZATION NAME -->

        <div class="organization">

            <h2>Animal Rescue PH</h2>

          
        </div>


        <!-- NAVIGATION -->

        <nav class="sidebar-navigation">


            <a
                href="{{ route('admin.dashboard') }}"
                class="sidebar-link active"
            >

                <i class="bi bi-house-fill"></i>

                <span>Dashboard</span>

            </a>

             <a 
    href="{{ route('admin.report-animal') }}" 
    class="sidebar-link" 
>
    <i class="bi bi-file-earmark-text-fill"></i>
    <span>Reports</span>
</a>
            
            <a
                 href="{{ route('admin.manage-animals') }}"
                class="sidebar-link"
            >

                <i class="bi bi-heart-pulse-fill"></i>

                <span>Manage Animals</span>

            </a>

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

          <form action="{{ route('logout') }}" method="POST">
    @csrf

    <button type="submit" class="logout-link">
        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>
    </button>
</form>
</form>

        </div>


    </aside>



    <!-- =====================================================
         MAIN CONTENT
    ====================================================== -->

    <main class="main-content">


        <!-- HEADER -->

        <div class="dashboard-header">


            <div>

                <h1>
                    Dash<span>board</span>
                </h1>

                <p>
                    Welcome, Admin! Here's our  overview of the shelter.
                </p>

            </div>

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



        <!-- =================================================
             SUMMARY CARDS
        ================================================== -->

        <section class="summary-grid">


            <!-- TOTAL ANIMALS -->

            <div class="summary-card">

                <div class="summary-icon orange">

                   <i class="fa-solid fa-paw"></i>

                </div>

                <h2>
                    {{ $totalAnimals }}
                </h2>

                <h3>
                    Total Animals
                </h3>

                <p>
                    Currently in Shelter
                </p>

            </div>



            <!-- PENDING ADOPTIONS -->

            <div class="summary-card">

                <div class="summary-icon pending">

                    <i class="bi bi-hourglass-split"></i>

                </div>

                <h2>
                    {{ $pendingAdoptions }}
                </h2>

                <h3>
                    Pending Adoptions
                </h3>

                <p>
                    Awaiting approval
                </p>

            </div>



            <!-- COMPLETED ADOPTIONS -->

            <div class="summary-card">

                <div class="summary-icon completed">

                    <i class="bi bi-check-lg"></i>

                </div>

                <h2>
                    {{ $completedAdoptions }}
                </h2>

                <h3>
                    Completed Adoptions
                </h3>

                <p>
                    Animals found their forever home
                </p>

            </div>



            <!-- NEW REPORTS -->

            <div class="summary-card">

                <div class="summary-icon reports">

                    <i class="bi bi-file-earmark-text"></i>

                </div>

                <h2>
                    {{ $pendingRescue }}
                </h2>

                <h3>
                    New Reports
                </h3>

                <p>
                    For review
                </p>

            </div>


        </section>



        <!-- =================================================
             SHELTER CAPACITY
        ================================================== -->

        <section class="capacity-grid">


            <!-- DOG CAPACITY -->

            <div class="capacity-card">


                <div class="animal-circle">

                    <i class="fa-solid fa-dog"></i>

                </div>


                <div class="capacity-information">

                    <h2>
                        Dogs in Shelter
                    </h2>


                    <div class="capacity-number">

                        <strong>
                            {{ $totalDogs }}
                        </strong>

                        <span>
                            / {{ $dogCapacity }}
                        </span>

                    </div>

<div class="capacity-bar">

    <div
        class="capacity-progress"
        data-current="{{ $totalDogs }}"
        data-capacity="{{ $dogCapacity }}"
    ></div>

</div>

                    <p>
                        {{ min(round(($totalDogs / $dogCapacity) * 100), 100) }}%
                    </p>

                </div>


            </div>



            <!-- CAT CAPACITY -->

            <div class="capacity-card">


                <div class="animal-circle">

                    <i class="fa-solid fa-cat"></i>

                </div>


                <div class="capacity-information">

                    <h2>
                        Cats in Shelter
                    </h2>


                    <div class="capacity-number">

                        <strong>
                            {{ $totalCats }}
                        </strong>

                        <span>
                            / {{ $catCapacity }}
                        </span>

                    </div>


                <div class="capacity-bar">

    <div
        class="capacity-progress"
        data-current="{{ $totalCats }}"
        data-capacity="{{ $catCapacity }}"
    ></div>

</div>    


                    <p>
                        {{ min(round(($totalCats / $catCapacity) * 100), 100) }}%
                    </p>

                </div>


            </div>


        </section>



        <!-- =================================================
             BREED GRAPHS
        ================================================== -->

        <section class="charts-grid">


            <!-- DOG BREEDS -->

            <div class="chart-card">


                <div class="chart-header">

                    <div>

                         <i class="fa-solid fa-dog"></i>

                        <h2>
                            Top Dog Breeds in Shelter
                        </h2>

                    </div>

                </div>


                <div class="chart-container">

                    <canvas id="dogBreedChart"></canvas>

                </div>


            </div>



            <!-- CAT BREEDS -->

            <div class="chart-card">


                <div class="chart-header">

                    <div>

                        <i class="fa-solid fa-cat"></i>


                        <h2>
                            Top Cat Breeds in Shelter
                        </h2>

                    </div>

                </div>


                <div class="chart-container">

                    <canvas id="catBreedChart"></canvas>

                </div>


            </div>


        </section>


    </main>

</div>



<!-- =====================================================
     CHART.JS
====================================================== -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- DOG BREED DATA -->

<div id="dogBreedData" style="display: none;">

    @foreach ($dogBreeds as $breed)

        <div
            class="breed-data"
            data-breed="{{ $breed->breed }}"
            data-total="{{ $breed->total }}"
        ></div>

    @endforeach

</div>


<!-- CAT BREED DATA -->

<div id="catBreedData" style="display: none;">

    @foreach ($catBreeds as $breed)

        <div
            class="breed-data"
            data-breed="{{ $breed->breed }}"
            data-total="{{ $breed->total }}"
        ></div>

    @endforeach

</div>
<!-- =====================================================
     DASHBOARD JAVASCRIPT
====================================================== -->
<script>

    /* =====================================================
       DOG BREED DATA
    ===================================================== */

    const dogBreedElements =
        document.querySelectorAll(
            '#dogBreedData .breed-data'
        );


    const dogBreedLabels = [];

    const dogBreedTotals = [];


    dogBreedElements.forEach(function (item) {

        dogBreedLabels.push(
            item.dataset.breed
        );

        dogBreedTotals.push(
            Number(item.dataset.total)
        );

    });



    /* =====================================================
       CAT BREED DATA
    ===================================================== */

    const catBreedElements =
        document.querySelectorAll(
            '#catBreedData .breed-data'
        );


    const catBreedLabels = [];

    const catBreedTotals = [];


    catBreedElements.forEach(function (item) {

        catBreedLabels.push(
            item.dataset.breed
        );

        catBreedTotals.push(
            Number(item.dataset.total)
        );

    });



    /* =====================================================
       CAPACITY BARS
    ===================================================== */

    const capacityBars =
        document.querySelectorAll(
            '.capacity-progress'
        );


    capacityBars.forEach(function (bar) {

        const current =
            Number(bar.dataset.current);

        const capacity =
            Number(bar.dataset.capacity);


        if (capacity <= 0) {
            bar.style.width = '0%';
            return;
        }


        const percentage =
            Math.min(
                (current / capacity) * 100,
                100
            );


        bar.style.width =
            percentage + '%';

    });



    /* =====================================================
       DOG BREED CHART
    =====================================/* =====================================================
   BREED CHART COLORS
===================================================== */

const dogBreedColors = [
    '#FF7A00', // Orange
    '#2563EB', // Blue
    '#16A34A', // Green
    '#8B5CF6', // Purple
    '#E11D48', // Rose
    '#0891B2', // Cyan
    '#F59E0B', // Amber
    '#7C3AED', // Violet
    '#DC2626', // Red
    '#14B8A6'  // Teal
];

const catBreedColors = [
    '#EA580C', // Deep Orange
    '#2563EB', // Blue
    '#22C55E', // Green
    '#A855F7', // Purple
    '#DB2777', // Pink
    '#06B6D4', // Cyan
    '#F59E0B', // Amber
    '#EF4444', // Red
    '#6366F1', // Indigo
    '#10B981'  // Emerald
];
    const dogChartElement =
        document.getElementById(
            'dogBreedChart'
        );


    if (dogChartElement) {

        new Chart(
            dogChartElement,
            {

                type: 'bar',

                data: {

                    labels:
                        dogBreedLabels,

                    datasets: [{

                        label:
                            'Number of Dogs',

                        data:
                            dogBreedTotals,

                       backgroundColor: dogBreedLabels.map(
    (_, index) => dogBreedColors[index % dogBreedColors.length]
),

                        borderRadius: 6,

                        borderSkipped:
                            false

                    }]

                },


                options: {

                    responsive: true,

                    maintainAspectRatio: false,


                    plugins: {

                        legend: {

                            display: false

                        }

                    },


                    scales: {

                        y: {

                            beginAtZero: true,

                            ticks: {

                                precision: 0

                            }

                        },


                        x: {

                            grid: {

                                display: false

                            }

                        }

                    }

                }

            }
        );

    }



    /* =====================================================
       CAT BREED CHART
    ===================================================== */

    const catChartElement =
        document.getElementById(
            'catBreedChart'
        );


    if (catChartElement) {

        new Chart(
            catChartElement,
            {

                type: 'bar',

                data: {

                    labels:
                        catBreedLabels,

                    datasets: [{

                        label:
                            'Number of Cats',

                        data:
                            catBreedTotals,

                       backgroundColor: catBreedLabels.map(
    (_, index) => catBreedColors[index % catBreedColors.length]
),

                        borderRadius: 6,

                        borderSkipped:
                            false

                    }]

                },


                options: {

                    responsive: true,

                    maintainAspectRatio: false,


                    plugins: {

                        legend: {

                            display: false

                        }

                    },


                    scales: {

                        y: {

                            beginAtZero: true,

                            ticks: {

                                precision: 0

                            }

                        },


                        x: {

                            grid: {

                                display: false

                            }

                        }

                    }

                }

            }
        );

    }
/* =========================================================
   ADMIN DROPDOWN
========================================================= */

const adminBadge = document.querySelector('.admin-badge');
const adminTrigger = document.getElementById('adminTrigger');

if (adminBadge && adminTrigger) {

    adminTrigger.addEventListener('click', function (event) {

        event.stopPropagation();

        adminBadge.classList.toggle('open');

    });


    document.addEventListener('click', function (event) {

        if (!adminBadge.contains(event.target)) {

            adminBadge.classList.remove('open');

        }

    });

}
</script>
    
   


</body>

</html>