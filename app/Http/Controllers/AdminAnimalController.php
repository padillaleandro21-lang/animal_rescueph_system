<?php

namespace App\Http\Controllers;
use App\Models\Animal;
use App\Models\AnimalReport;
use App\Models\Cage;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class AdminAnimalController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | RESCUED ANIMALS
        |--------------------------------------------------------------------------
        | These come from the Report Animal page.
        |
        | When the admin clicks the Rescue button,
        | the report status becomes "Rescued".
        */

     $registeredReportIds = Animal::whereNotNull('report_id')
    ->pluck('report_id');

$rescuedAnimals = AnimalReport::where(
    'status',
    'Rescued'
)
->whereNull('archived_at')
->whereNotIn('id', $registeredReportIds)
->latest()
->get();
        /*
        |--------------------------------------------------------------------------
        | REGISTERED ANIMALS
        |--------------------------------------------------------------------------
        | These are official animal records already saved
        | inside the animals table.
        */

        $registeredAnimals = Animal::query()
    ->orderByRaw("
        CASE LOWER(TRIM(status))
            WHEN 'registered' THEN 1
            WHEN 'under treatment' THEN 2
            WHEN 'for adoption' THEN 3
            WHEN 'adopted' THEN 4
            ELSE 5
        END
    ")
    ->latest('id')
    ->paginate(10, ['*'], 'registered_page')
    ->withQueryString();
    
    
        /*
        |--------------------------------------------------------------------------
        | RESCUED DOGS
        |--------------------------------------------------------------------------
        | Counts rescued dogs from animal_reports.
        */

        $dogCount = AnimalReport::where(
            'status',
            'Rescued'
        )
        ->whereNull('archived_at')
        ->whereRaw(
            'LOWER(animal_type) = ?',
            ['dog']
        )
        ->count();


        /*
        |--------------------------------------------------------------------------
        | RESCUED CATS
        |--------------------------------------------------------------------------
        | Counts rescued cats from animal_reports.
        */

        $catCount = AnimalReport::where(
            'status',
            'Rescued'
        )
        ->whereNull('archived_at')
        ->whereRaw(
            'LOWER(animal_type) = ?',
            ['cat']
        )
        ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL RESCUED
        |--------------------------------------------------------------------------
        */

        $totalRescued = $rescuedAnimals->count();


        /*
        |--------------------------------------------------------------------------
        | REGISTERED DOGS
        |--------------------------------------------------------------------------
        | Counts dogs that have already been officially registered.
        */
$registeredDogCount = Animal::whereRaw(
    "LOWER(TRIM(animal_type)) = ?",
    ['dog']
)
->where(function ($query) {
    $query->whereNull('status')
        ->orWhereRaw(
            "LOWER(TRIM(status)) != ?",
            ['adopted']
        );
})
->count();


/*
|--------------------------------------------------------------------------
| REGISTERED CATS
|--------------------------------------------------------------------------
| Adopted cats remain in the database but are not counted
| as currently registered/in-shelter cats.
*/

$registeredCatCount = Animal::whereRaw(
    "LOWER(TRIM(animal_type)) = ?",
    ['cat']
)
->where(function ($query) {
    $query->whereNull('status')
        ->orWhereRaw(
            "LOWER(TRIM(status)) != ?",
            ['adopted']
        );
})
->count();


/*
|--------------------------------------------------------------------------
| TOTAL REGISTERED
|--------------------------------------------------------------------------
| All official animal records are retained, including adopted animals.
*/

$totalRegistered = Animal::where(function ($query) {
    $query->whereNull('status')
        ->orWhereRaw(
            "LOWER(TRIM(status)) != ?",
            ['adopted']
        );
})->count();


/*
|--------------------------------------------------------------------------
| SHELTER CAPACITY
|--------------------------------------------------------------------------
*/

$dogCapacity = 700;

$catCapacity = 100;


/*
|--------------------------------------------------------------------------
| DOG CAPACITY PERCENTAGE
|--------------------------------------------------------------------------
*/

$dogPercentage = $dogCapacity > 0
    ? min(
        ($registeredDogCount / $dogCapacity) * 100,
        100
    )
    : 0;


/*
|--------------------------------------------------------------------------
| CAT CAPACITY PERCENTAGE
|--------------------------------------------------------------------------
*/

$catPercentage = $catCapacity > 0
    ? min(
        ($registeredCatCount / $catCapacity) * 100,
        100
    )
    : 0;
        /*
        |--------------------------------------------------------------------------
        | RETURN MANAGE ANIMALS PAGE
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.manage-animals',
            compact(
                'rescuedAnimals',
                'registeredAnimals',

                'totalRescued',

                'dogCount',
                'catCount',

                'totalRegistered',

                'registeredDogCount',
                'registeredCatCount',

                'dogCapacity',
                'catCapacity',

                'dogPercentage',
                'catPercentage'
            )
        );
        
    }
    
      /**
 * Display all registered dogs.
 */
public function registeredDogs(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | BASE QUERY
    |--------------------------------------------------------------------------
    | Only registered Dogs are shown.
    */

    $query = Animal::query()
        ->whereRaw(
            'LOWER(TRIM(animal_type)) = ?',
            ['dog']
        );


    /*
    |--------------------------------------------------------------------------
    | BREED FILTER
    |--------------------------------------------------------------------------
    */

    if ($request->filled('breed')) {

        $breed = trim($request->breed);

        $query->whereRaw(
            'LOWER(TRIM(breed)) = ?',
            [strtolower($breed)]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS FILTER
    |--------------------------------------------------------------------------
    */

    if ($request->filled('status')) {

        $status = trim($request->status);

        $query->whereRaw(
            'LOWER(TRIM(status)) = ?',
            [strtolower($status)]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    | Searches:
    | - Animal name
    | - Breed
    | - Animal ID
    */

    if ($request->filled('search')) {

        $search = trim($request->search);

        $query->where(function ($q) use ($search) {

            $q->where(
                'name',
                'LIKE',
                '%' . $search . '%'
            )

            ->orWhere(
                'breed',
                'LIKE',
                '%' . $search . '%'
            )

            ->orWhere(
                'id',
                'LIKE',
                '%' . $search . '%'
            );

        });
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTERED DOGS
    |--------------------------------------------------------------------------
    | withQueryString() keeps the selected filters
    | when moving between pagination pages.
    */

   $dogs = $query
    ->with('cage')
    ->orderByRaw("
        CASE LOWER(TRIM(status))
            WHEN 'for adoption'    THEN 1
            WHEN 'under treatment' THEN 2
            WHEN 'registered'      THEN 3
            WHEN 'adopted'         THEN 4
            ELSE 5
        END
    ")
    ->orderByRaw("
        CASE LOWER(TRIM(gender))
            WHEN 'female' THEN 1
            WHEN 'male'   THEN 2
            ELSE 3
        END
    ")
    ->orderBy('name', 'asc')
    ->paginate(10)
    ->withQueryString();

    /*
    |--------------------------------------------------------------------------
    | BREED OPTIONS
    |--------------------------------------------------------------------------
    | Get the actual breeds currently registered as Dogs.
    */

    $breeds = Animal::query()
        ->whereRaw(
            'LOWER(TRIM(animal_type)) = ?',
            ['dog']
        )
        ->whereNotNull('breed')
        ->whereRaw("TRIM(breed) != ''")
        ->select('breed')
        ->distinct()
        ->orderBy('breed')
        ->pluck('breed');


    /*
    |--------------------------------------------------------------------------
    | STATUS OPTIONS
    |--------------------------------------------------------------------------
    */

    $statuses = [
        'For Adoption',
        'Under Treatment',
        'Adopted',
    ];


    /*
    |--------------------------------------------------------------------------
    | TOTAL REGISTERED DOGS
    |--------------------------------------------------------------------------
    */

    $totalDogs = Animal::query()
        ->whereRaw(
            'LOWER(TRIM(animal_type)) = ?',
            ['dog']
        )
        ->count();


    /*
    |--------------------------------------------------------------------------
    | ACTIVE DOGS FOR AGE GRAPH
    |--------------------------------------------------------------------------
    |
    | Adopted dogs are excluded.
    |
    | We do NOT delete them from the database.
    |
    */

    $activeDogs = Animal::query()
        ->whereRaw(
            'LOWER(TRIM(animal_type)) = ?',
            ['dog']
        )
        ->where(function ($query) {

            $query
                ->whereNull('status')
                ->orWhereRaw(
                    'LOWER(TRIM(status)) != ?',
                    ['adopted']
                );

        });


    /*
    |--------------------------------------------------------------------------
    | YOUNG DOGS
    |--------------------------------------------------------------------------
    */
$youngDogs = (clone $activeDogs)
    ->whereRaw(
        "LOWER(TRIM(REPLACE(age, ' years', ''))) = ?",
        ['young']
    )
    ->count();


$adultDogs = (clone $activeDogs)
    ->whereRaw(
        "LOWER(TRIM(REPLACE(age, ' years', ''))) = ?",
        ['adult']
    )
    ->count();


$oldDogs = (clone $activeDogs)
    ->whereRaw(
        "LOWER(TRIM(REPLACE(age, ' years', ''))) = ?",
        ['old']
    )
    ->count();
    /*
    |--------------------------------------------------------------------------
    | AGE COUNTS
    |--------------------------------------------------------------------------
    */

    $ageCounts = [

        'young' => $youngDogs,

        'adult' => $adultDogs,

        'old' => $oldDogs,

    ];


    /*
    |--------------------------------------------------------------------------
    | RETURN VIEW
    |--------------------------------------------------------------------------
    */
    return view(
        'admin.registered-dogs',
        compact(
            'dogs',
            'breeds',
            'statuses',
            'totalDogs',
            'ageCounts'
        )
    );
}


/**
 * Display all registered cats.
 */
public function registeredCats(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | BASE QUERY
    |--------------------------------------------------------------------------
    | Only registered Cats are shown.
    */

    $query = Animal::query()
        ->whereRaw(
            'LOWER(TRIM(animal_type)) = ?',
            ['cat']
        );


    /*
    |--------------------------------------------------------------------------
    | BREED FILTER
    |--------------------------------------------------------------------------
    */

    if ($request->filled('breed')) {

        $breed = trim($request->breed);

        $query->whereRaw(
            'LOWER(TRIM(breed)) = ?',
            [strtolower($breed)]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS FILTER
    |--------------------------------------------------------------------------
    */

    if ($request->filled('status')) {

        $status = trim($request->status);

        $query->whereRaw(
            'LOWER(TRIM(status)) = ?',
            [strtolower($status)]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    if ($request->filled('search')) {

        $search = trim($request->search);

        $query->where(function ($q) use ($search) {

            $q->where(
                'name',
                'LIKE',
                '%' . $search . '%'
            )
            ->orWhere(
                'breed',
                'LIKE',
                '%' . $search . '%'
            )
            ->orWhere(
                'id',
                'LIKE',
                '%' . $search . '%'
            );

        });
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTERED CATS
    |--------------------------------------------------------------------------
    */

      $cats = $query
    ->with('cage')
    ->orderByRaw("
        CASE LOWER(TRIM(status))
            WHEN 'for adoption'    THEN 1
            WHEN 'under treatment' THEN 2
            WHEN 'registered'      THEN 3
            WHEN 'adopted'         THEN 4
            ELSE 5
        END
    ")
    ->orderByRaw("
        CASE LOWER(TRIM(gender))
            WHEN 'female' THEN 1
            WHEN 'male'   THEN 2
            ELSE 3
        END
    ")
    ->orderBy('name', 'asc')
    ->paginate(10)
    ->withQueryString();

    /*
    |--------------------------------------------------------------------------
    | BREED OPTIONS
    |--------------------------------------------------------------------------
    */

    $breeds = Animal::query()
        ->whereRaw(
            'LOWER(TRIM(animal_type)) = ?',
            ['cat']
        )
        ->whereNotNull('breed')
        ->whereRaw("TRIM(breed) != ''")
        ->select('breed')
        ->distinct()
        ->orderBy('breed')
        ->pluck('breed');


    /*
    |--------------------------------------------------------------------------
    | STATUS OPTIONS
    |--------------------------------------------------------------------------
    */

    $statuses = [
        'For Adoption',
        'Under Treatment',
        'Adopted',
    ];


    /*
    |--------------------------------------------------------------------------
    | TOTAL REGISTERED CATS
    |--------------------------------------------------------------------------
    */

    $totalCats = Animal::query()
        ->whereRaw(
            'LOWER(TRIM(animal_type)) = ?',
            ['cat']
        )
        ->count();


    /*
    |--------------------------------------------------------------------------
    | ACTIVE CATS FOR AGE GRAPH
    |--------------------------------------------------------------------------
    | Adopted cats are excluded.
    | They remain in the database.
    */

    $activeCats = Animal::query()
        ->whereRaw(
            'LOWER(TRIM(animal_type)) = ?',
            ['cat']
        )
        ->where(function ($query) {

            $query
                ->whereNull('status')
                ->orWhereRaw(
                    'LOWER(TRIM(status)) != ?',
                    ['adopted']
                );

        });


    /*
    |--------------------------------------------------------------------------
    | YOUNG CATS
    |--------------------------------------------------------------------------
    */

    $youngCats = (clone $activeCats)
        ->whereRaw(
            'LOWER(TRIM(age)) = ?',
            ['young']
        )
        ->count();


    /*
    |--------------------------------------------------------------------------
    | ADULT CATS
    |--------------------------------------------------------------------------
    */

    $adultCats = (clone $activeCats)
        ->whereRaw(
            'LOWER(TRIM(age)) = ?',
            ['adult']
        )
        ->count();


    /*
    |--------------------------------------------------------------------------
    | OLD CATS
    |--------------------------------------------------------------------------
    */

    $oldCats = (clone $activeCats)
        ->whereRaw(
            'LOWER(TRIM(age)) = ?',
            ['old']
        )
        ->count();


    /*
    |--------------------------------------------------------------------------
    | AGE COUNTS
    |--------------------------------------------------------------------------
    */

    $ageCounts = [

        'young' => $youngCats,

        'adult' => $adultCats,

        'old' => $oldCats,

    ];


    /*
    |--------------------------------------------------------------------------
    | RETURN CAT VIEW
    |--------------------------------------------------------------------------
    */

    return view(
        'admin.registered-cats',
        compact(
            'cats',
            'breeds',
            'statuses',
            'totalCats',
            'ageCounts'
        
    
            )

            
    );
}
    /**
 * Show one registered dog.
 */
public function showRegisteredDog($id)
{
    $dog = Animal::query()
        ->where('id', $id)
        ->whereRaw(
            'LOWER(TRIM(animal_type)) = ?',
            ['dog']
        )
        ->with('cage')
        ->firstOrFail();

    return view(
        'admin.registered-dog-view',
        compact('dog')
    );
}
public function animalCages(Request $request)
{
    $type = strtolower($request->query('type', 'dog'));

    if (!in_array($type, ['dog', 'cat'])) {
        $type = 'dog';
    }

    $search = trim($request->query('search', ''));

    $cagesQuery = Cage::whereRaw(
        'LOWER(animal_type) = ?',
        [$type]
    )
    ->withCount('animals')
    ->with('animals')
    ->orderBy('cage_number');

    if ($search !== '') {
        $cagesQuery->where('cage_number', 'like', '%' . $search . '%');
    }

    $cages = $cagesQuery
        ->paginate(10)
        ->withQueryString();

    /* Stats for summary cards */
    $totalCages    = Cage::count();
    $dogCages      = Cage::whereRaw('LOWER(animal_type) = ?', ['dog'])->count();
    $catCages      = Cage::whereRaw('LOWER(animal_type) = ?', ['cat'])->count();

    $dogOccupied   = Animal::whereHas('cage', fn($q) => $q->whereRaw('LOWER(animal_type) = ?', ['dog']))->count();
    $catOccupied   = Animal::whereHas('cage', fn($q) => $q->whereRaw('LOWER(animal_type) = ?', ['cat']))->count();

    $dogTotalSlots = $dogCages * 5;
    $catTotalSlots = $catCages * 5;

    $dogAvailable  = max($dogTotalSlots - $dogOccupied, 0);
    $catAvailable  = max($catTotalSlots - $catOccupied, 0);

    $selectedCage  = null;

    return view('admin.animal-cages', compact(
        'cages',
        'type',
        'search',
        'selectedCage',
        'totalCages',
        'dogCages',
        'catCages',
        'dogOccupied',
        'catOccupied',
        'dogTotalSlots',
        'catTotalSlots',
        'dogAvailable',
        'catAvailable'
    ));
}
public function exportRescuedAnimal($id)
{
    $animal = AnimalReport::findOrFail($id);

    $pdf = Pdf::loadView(
        'admin.rescued-animal-export',
        compact('animal')
    );

    return $pdf->download(
        'rescued-animal-' . $animal->id . '.pdf'
    );
}
public function exportRegisteredAnimal(int $id)
{
    $animal = Animal::with('cage')->findOrFail($id);

    $pdf = Pdf::loadView(
        'admin.registered-animal-export',
        compact('animal')
    );

    return $pdf->download(
        'registered-animal-' . $animal->id . '.pdf'
    );
}

public function exportRescuedAnimalsMonthly(
    \Illuminate\Http\Request $request
) {
    $validated = $request->validate([
        'month' => ['required', 'integer', 'between:1,12'],
        'year' => [
            'required',
            'integer',
            'min:2000',
            'max:' . now()->year,
        ],
    ]);

    $month = (int) $validated['month'];
    $year = (int) $validated['year'];

    $monthName = \Carbon\Carbon::create()
        ->month($month)
        ->format('F');

    $query = \App\Models\AnimalReport::query()
        ->where('status', 'Rescued')
        ->whereYear('updated_at', $year)
        ->whereMonth('updated_at', $month)
        ->orderBy('updated_at')
        ->orderBy('id');

    $filename = "rescued_animals_{$monthName}_{$year}.csv";

    return response()->streamDownload(function () use ($query) {
        $output = fopen('php://output', 'w');

        // Excel-compatible UTF-8 encoding
        fwrite($output, "\xEF\xBB\xBF");

        fputcsv($output, [
            'Report ID',
            'Animal Type',
            'Breed',
            'Reporter First Name',
            'Reporter Last Name',
            'Email',
            'Contact Number',
            'House / Street',
            'Barangay',
            'City / Municipality',
            'Province',
            'Additional Notes',
            'Date',
            'Status',
        ]);

        $query->chunk(500, function ($reports) use ($output) {
            foreach ($reports as $report) {
                fputcsv($output, [
                    $report->id,
                    $report->animal_type,
                    $report->breed,
                    $report->first_name,
                    $report->last_name,
                    $report->email,
                    $report->contact_number,
                    $report->house_street,
                    $report->barangay,
                    $report->city_municipality,
                    $report->province,
                    $report->additional_notes,
                    $report->updated_at?->format('M d, Y h:i A') ?? '',
                    $report->status,
                ]);
            }
        });

        fclose($output);
    }, $filename, [
        'Content-Type' => 'text/csv; charset=UTF-8',
    ]);
}
public function exportAdoptionsMonthly(
    \Illuminate\Http\Request $request
) {
    $validated = $request->validate([
        'month' => 'required|integer|min:1|max:12',
        'year' => 'required|integer|min:2024|max:' . now()->year,
    ]);

    $month = (int) $validated['month'];
    $year = (int) $validated['year'];

    $applications = \App\Models\AdoptionApplication::with('animal')
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->orderBy('created_at')
        ->get();

    $filename = sprintf(
        'adoption-applications-%04d-%02d.csv',
        $year,
        $month
    );

    return response()->streamDownload(function () use ($applications) {
        $output = fopen('php://output', 'w');

        // UTF-8 BOM para maayos mabuksan sa Excel
        fwrite($output, "\xEF\xBB\xBF");

        fputcsv($output, [
            'Application ID',
            'Applicant Name',
            'Email',
            'Contact Number',
            'Pet Name',
            'Animal Type',
            'Breed',
            'Status',
            'Date Submitted',
        ]);

        foreach ($applications as $application) {
            fputcsv($output, [
                $application->id,
                trim(($application->first_name ?? '') . ' ' . ($application->last_name ?? '')),
                $application->email,
                $application->contact_number,
                $application->animal->name ?? 'Unknown',
                $application->animal->animal_type ?? 'Unknown',
                $application->animal->breed ?? 'Unknown',
                $application->status,
                optional($application->created_at)->format('Y-m-d H:i:s'),
            ]);
        }

        fclose($output);
    }, $filename, [
        'Content-Type' => 'text/csv; charset=UTF-8',
    ]);
}
}

