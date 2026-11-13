<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>Rescued Animal Report</title>

    <style>

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #111827;
            font-size: 14px;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            color: #f97316;
            font-size: 26px;
        }

        .header p {
            margin: 5px 0;
            color: #6b7280;
        }

        .header h2 {
            margin-top: 15px;
            font-size: 20px;
            color: #111827;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            background: #f97316;
            color: #ffffff;
            padding: 9px 12px;
            font-size: 15px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 9px;
            border: 1px solid #e5e7eb;
        }

        td:first-child {
            width: 30%;
            background: #fff7ed;
            font-weight: bold;
        }

        .status {
            color: #16a34a;
            font-weight: bold;
        }

        .notes {
            border: 1px solid #e5e7eb;
            padding: 12px;
            min-height: 50px;
        }

    </style>

</head>

<body>

    <!-- HEADER -->

    <div class="header">

        <h1>IARAMS</h1>

        <p>
            Integrated Animal Rescue and Adoption Management System
        </p>

        <h2>
            Rescued Animal Report
        </h2>

    </div>


    <!-- ANIMAL INFORMATION -->

    <div class="section">

        <div class="section-title">
            Animal Information
        </div>

        <table>

            <tr>
                <td>Animal Type</td>

                <td>
                    {{ $animal->animal_type ?? 'Unknown' }}
                </td>
            </tr>

            <tr>
                <td>Breed</td>

                <td>
                    {{ $animal->breed ?? 'Unknown' }}
                </td>
            </tr>

            <tr>
                <td>Status</td>

                <td class="status">
                    {{ $animal->status ?? 'Rescued' }}
                </td>
            </tr>

            <tr>
                <td>Date Rescued</td>

                <td>
                    {{ $animal->updated_at
                        ? $animal->updated_at->format('F d, Y h:i A')
                        : 'N/A'
                    }}
                </td>
            </tr>

        </table>

    </div>


    <!-- LOCATION -->

    <div class="section">

        <div class="section-title">
            Rescue Location
        </div>

        <table>

            <tr>
                <td>Street</td>

                <td>
                    {{ $animal->house_street ?? 'N/A' }}
                </td>
            </tr>

            <tr>
                <td>Barangay</td>

                <td>
                    {{ $animal->barangay ?? 'N/A' }}
                </td>
            </tr>

            <tr>
                <td>City / Municipality</td>

                <td>
                    {{ $animal->city_municipality ?? 'N/A' }}
                </td>
            </tr>

            <tr>
                <td>Province</td>

                <td>
                    {{ $animal->province ?? 'N/A' }}
                </td>
            </tr>

        </table>

    </div>


    <!-- REPORTER INFORMATION -->

    <div class="section">

        <div class="section-title">
            Reporter Information
        </div>

        <table>

            <tr>
                <td>Full Name</td>

                <td>
                    {{ $animal->first_name ?? '' }}
                    {{ $animal->last_name ?? '' }}
                </td>
            </tr>

            <tr>
                <td>Email</td>

                <td>
                    {{ $animal->email ?? 'N/A' }}
                </td>
            </tr>

            <tr>
                <td>Contact Number</td>

                <td>
                    {{ $animal->contact_number ?? 'N/A' }}
                </td>
            </tr>

        </table>

    </div>


    <!-- ADDITIONAL NOTES -->

    <div class="section">

        <div class="section-title">
            Additional Notes
        </div>

        <div class="notes">

            {{ $animal->additional_notes ?? 'No additional notes.' }}

        </div>

    </div>

</body>
</html>