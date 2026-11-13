<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\Animal;
use App\Models\AnimalReport;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | CURRENT SHELTER ANIMALS
        |--------------------------------------------------------------------------
        |
        | Adopted animals remain in the database for historical records.
        | They are excluded from the current shelter count.
        |
        */

        $totalAnimals = Animal::where(function ($query) {
            $query->whereNull('status')
                ->orWhereRaw(
                    "LOWER(TRIM(status)) != ?",
                    ['adopted']
                );
        })->count();


        /*
        |--------------------------------------------------------------------------
        | DOGS IN SHELTER
        |--------------------------------------------------------------------------
        */

        $totalDogs = Animal::whereRaw(
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
        | CATS IN SHELTER
        |--------------------------------------------------------------------------
        */

        $totalCats = Animal::whereRaw(
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
        | ADOPTED ANIMALS
        |--------------------------------------------------------------------------
        |
        | These remain in the database but are no longer inside the shelter.
        |
        */

        $adoptedTotal = Animal::whereRaw(
            "LOWER(TRIM(status)) = ?",
            ['adopted']
        )->count();


        /*
        |--------------------------------------------------------------------------
        | PENDING ADOPTIONS
        |--------------------------------------------------------------------------
        */

        $pendingAdoptions = AdoptionApplication::whereRaw(
            "LOWER(TRIM(status)) = ?",
            ['pending']
        )->count();


        /*
        |--------------------------------------------------------------------------
        | COMPLETED ADOPTIONS
        |--------------------------------------------------------------------------
        */

        $completedAdoptions = AdoptionApplication::whereRaw(
            "LOWER(TRIM(status)) = ?",
            ['completed']
        )->count();


        /*
        |--------------------------------------------------------------------------
        | PENDING RESCUE REPORTS
        |--------------------------------------------------------------------------
        */

        $pendingRescue = AnimalReport::whereRaw(
            "LOWER(TRIM(status)) = ?",
            ['pending']
        )->count();


        /*
        |--------------------------------------------------------------------------
        | NEW REPORTS
        |--------------------------------------------------------------------------
        |
        | Get the latest pending rescue reports.
        |
        | IMPORTANT:
        | Do not use ->with('animal') here because the current
        | AnimalReport model does not have an animal() relationship.
        |
        */

        $newReports = AnimalReport::whereRaw(
            "LOWER(TRIM(status)) = ?",
            ['pending']
        )
        ->latest()
        ->take(6)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | RECENT ADOPTION APPLICATIONS
        |--------------------------------------------------------------------------
        */

        $recentApplications = AdoptionApplication::with([
            'animal',
            'user'
        ])
        ->latest()
        ->take(6)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | MONITORING QUEUE
        |--------------------------------------------------------------------------
        |
        | Approved applications are currently going through the
        | adoption monitoring process.
        |
        */

        $monitoringQueue = AdoptionApplication::with([
            'animal',
            'monitorings'
        ])
        ->whereRaw(
            "LOWER(TRIM(status)) = ?",
            ['approved']
        )
        ->latest()
        ->take(6)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | TOP DOG BREEDS IN SHELTER
        |--------------------------------------------------------------------------
        |
        | Adopted dogs are excluded.
        |
        */

        $dogBreeds = Animal::select(
            'breed',
            DB::raw('COUNT(*) as total')
        )
        ->whereRaw(
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
        ->whereNotNull('breed')
        ->whereRaw("TRIM(breed) != ''")
        ->groupBy('breed')
        ->orderByDesc('total')
        ->limit(5)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | TOP CAT BREEDS IN SHELTER
        |--------------------------------------------------------------------------
        |
        | Adopted cats are excluded.
        |
        */

        $catBreeds = Animal::select(
            'breed',
            DB::raw('COUNT(*) as total')
        )
        ->whereRaw(
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
        ->whereNotNull('breed')
        ->whereRaw("TRIM(breed) != ''")
        ->groupBy('breed')
        ->orderByDesc('total')
        ->limit(5)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | SHELTER CAPACITY
        |--------------------------------------------------------------------------
        */

        $dogCapacity = 700;
        $catCapacity = 100;


        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',
            compact(
                'totalAnimals',
                'totalDogs',
                'totalCats',

                'adoptedTotal',

                'pendingAdoptions',
                'completedAdoptions',

                'pendingRescue',

                'newReports',
                'recentApplications',
                'monitoringQueue',

                'dogBreeds',
                'catBreeds',

                'dogCapacity',
                'catCapacity'
            )
        );
    }
}