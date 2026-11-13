<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>Registered Animal Report</title>

    <style>

        @page {
            margin: 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
        }

        /* ==============================
           HEADER
        ============================== */

        .header {
            text-align: center;
            border-bottom: 3px solid #f97316;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #f97316;
        }

        .header h2 {
            margin: 4px 0 0;
            font-size: 16px;
            color: #111827;
        }

        .header p {
            margin: 4px 0 0;
            font-size: 10px;
            color: #6b7280;
        }


        /* ==============================
           ANIMAL IMAGE
        ============================== */

        .animal-photo-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .animal-photo {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border: 3px solid #f97316;
            border-radius: 10px;
        }

        .photo-placeholder {
            width: 180px;
            height: 180px;
            margin: 0 auto;
            background: #f3f4f6;
            border: 2px solid #d1d5db;
            text-align: center;
            line-height: 180px;
            color: #9ca3af;
        }


        /* ==============================
           SECTION TITLE
        ============================== */

        .section-title {
            background: #f97316;
            color: #ffffff;
            padding: 8px 10px;
            margin-top: 18px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: bold;
        }


        /* ==============================
           INFORMATION TABLE
        ============================== */

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .details-table td {
            border: 1px solid #e5e7eb;
            padding: 8px 10px;
            vertical-align: top;
        }

        .details-table .label {
            width: 30%;
            background: #fff7ed;
            color: #374151;
            font-weight: bold;
        }

        .details-table .value {
            width: 70%;
            color: #111827;
        }


        /* ==============================
           STATUS
        ============================== */

        .status {
            font-weight: bold;
            color: #f97316;
        }


        /* ==============================
           NOTES
        ============================== */

        .notes {
            min-height: 40px;
        }


        /* ==============================
           FOOTER
        ============================== */

        .footer {
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1px solid #d1d5db;
            text-align: center;
            color: #6b7280;
            font-size: 9px;
        }

    </style>

</head>

<body>


    {{-- ==========================================
         HEADER
    =========================================== --}}

    <div class="header">

        <h1>
            ANIMAL RESCUE PH
        </h1>

        <h2>
            Registered Animal Report
        </h2>

        <p>
            Integrated Animal Rescue and Adoption Management System
        </p>

    </div>


    {{-- ==========================================
         ANIMAL PHOTO
    =========================================== --}}

    <div class="animal-photo-section">

        @if($animal->animal_image)

            <img
                src="{{ public_path('uploads/animals/' . $animal->animal_image) }}"
                class="animal-photo"
                alt="Animal Image"
            >

        @else

            <div class="photo-placeholder">
                No Animal Image
            </div>

        @endif

    </div>


    {{-- ==========================================
         ANIMAL INFORMATION
    =========================================== --}}

    <div class="section-title">
        Animal Information
    </div>

    <table class="details-table">

        <tr>
            <td class="label">
                Animal ID
            </td>

            <td class="value">
                {{ $animal->id }}
            </td>
        </tr>


        <tr>
            <td class="label">
                Animal Name
            </td>

            <td class="value">
                {{ $animal->name ?: 'Unknown' }}
            </td>
        </tr>


        <tr>
            <td class="label">
                Animal Type
            </td>

            <td class="value">
                {{ $animal->animal_type ?: 'Unknown' }}
            </td>
        </tr>


        <tr>
            <td class="label">
                Breed
            </td>

            <td class="value">
                {{ $animal->breed ?: 'Unknown' }}
            </td>
        </tr>


        <tr>
            <td class="label">
                Age
            </td>

            <td class="value">
                {{ $animal->age ?: 'Unknown' }}
            </td>
        </tr>


        <tr>
            <td class="label">
                Gender
            </td>

            <td class="value">
                {{ $animal->gender ?: 'Unknown' }}
            </td>
        </tr>


        <tr>
            <td class="label">
                Weight
            </td>

            <td class="value">
                {{ $animal->weight ?: 'Unknown' }}
            </td>
        </tr>


        <tr>
            <td class="label">
                Height
            </td>

            <td class="value">
                {{ $animal->height ?: 'Unknown' }}
            </td>
        </tr>

    </table>


    {{-- ==========================================
         REGISTRATION INFORMATION
    =========================================== --}}

    <div class="section-title">
        Registration Information
    </div>

    <table class="details-table">

        <tr>
            <td class="label">
                Status
            </td>

            <td class="value">
                <span class="status">
                    {{ $animal->status ?: 'Unknown' }}
                </span>
            </td>
        </tr>


        <tr>
            <td class="label">
                Date Acquired
            </td>

            <td class="value">

                @if($animal->date_acquired)

                    {{ $animal->date_acquired->format('F d, Y') }}

                @else

                    Unknown

                @endif

            </td>
        </tr>


        <tr>
            <td class="label">
                Source Type
            </td>

            <td class="value">
                {{ $animal->source_type ?: 'Unknown' }}
            </td>
        </tr>


        <tr>
            <td class="label">
                Rescue Report ID
            </td>

            <td class="value">
                {{ $animal->report_id ?: 'None' }}
            </td>
        </tr>


        <tr>
            <td class="label">
                Location Found
            </td>

            <td class="value">
                {{ $animal->location_found ?: 'Unknown' }}
            </td>
        </tr>

    </table>


    {{-- ==========================================
         SHELTER / CAGE INFORMATION
    =========================================== --}}

    <div class="section-title">
        Shelter Information
    </div>

    <table class="details-table">

        <tr>
            <td class="label">
                Cage Number
            </td>

            <td class="value">

                @if($animal->cage)

                    {{ $animal->cage->cage_number }}

                @else

                    Not Assigned

                @endif

            </td>
        </tr>


        <tr>
            <td class="label">
                Cage ID
            </td>

            <td class="value">
                {{ $animal->cage_id ?: 'Not Assigned' }}
            </td>
        </tr>

    </table>


    {{-- ==========================================
         HEALTH INFORMATION
    =========================================== --}}

    <div class="section-title">
        Health Information
    </div>

    <table class="details-table">

        <tr>
            <td class="label">
                Health Condition
            </td>

            <td class="value">
                {{ $animal->health_condition ?: 'Not specified' }}
            </td>
        </tr>


        <tr>
            <td class="label">
                Medical Notes
            </td>

            <td class="value notes">
                {{ $animal->medical_notes ?: 'None recorded' }}
            </td>
        </tr>


        <tr>
            <td class="label">
                Vaccinations
            </td>

            <td class="value">

                @if(!empty($animal->vaccinations))

                    @if(is_array($animal->vaccinations))

                        @foreach($animal->vaccinations as $vaccination)

                            @if(is_array($vaccination))

                                {{ implode(' - ', $vaccination) }}

                            @else

                                {{ $vaccination }}

                            @endif

                            @if(!$loop->last)
                                <br>
                            @endif

                        @endforeach

                    @else

                        {{ $animal->vaccinations }}

                    @endif

                @else

                    No vaccination records

                @endif

            </td>
        </tr>

    </table>


    {{-- ==========================================
         ADDITIONAL NOTES
    =========================================== --}}

    <div class="section-title">
        Additional Notes
    </div>

    <table class="details-table">

        <tr>

            <td class="label">
                Notes
            </td>

            <td class="value notes">
                {{ $animal->additional_notes ?: 'No additional notes.' }}
            </td>

        </tr>

    </table>


    {{-- ==========================================
         FOOTER
    =========================================== --}}

    <div class="footer">

        <strong>Animal Rescue PH</strong><br>

        Integrated Animal Rescue and Adoption Management System (IARAMS)<br>

        This document is an official registered animal record generated by the system.

    </div>


</body>
</html>