<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Cage;
use Illuminate\Http\Request;

class AdminCageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CAGE MANAGEMENT PAGE
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. DETERMINE WHICH TAB IS ACTIVE
        |--------------------------------------------------------------------------
        |
        | Default tab = Dog
        |
        | Dog:
        | /admin/cages?type=dog
        |
        | Cat:
        | /admin/cages?type=cat
        |
        */

        $type = strtolower(
            $request->query('type', 'dog')
        );


        /*
        |--------------------------------------------------------------------------
        | Only allow Dog or Cat
        |--------------------------------------------------------------------------
        */

        if (!in_array($type, ['dog', 'cat'])) {

            $type = 'dog';

        }


        /*
        |--------------------------------------------------------------------------
        | 2. SEARCH
        |--------------------------------------------------------------------------
        */

        $search = trim(
            $request->query('search', '')
        );


        /*
        |--------------------------------------------------------------------------
        | 3. GET CAGES
        |--------------------------------------------------------------------------
        */

        $cagesQuery = Cage::whereRaw(
            'LOWER(animal_type) = ?',
            [$type]
        )
        ->withCount('animals')
        ->with('animals')
        ->orderBy('cage_number');


        /*
        |--------------------------------------------------------------------------
        | SEARCH BY CAGE NUMBER
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $cagesQuery->where(
                'cage_number',
                'like',
                '%' . $search . '%'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | 4. PAGINATION
        |--------------------------------------------------------------------------
        */

        $cages = $cagesQuery
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | 5. TOTAL CAGES
        |--------------------------------------------------------------------------
        */

        $totalCages = Cage::count();


        /*
        |--------------------------------------------------------------------------
        | DOG CAGES
        |--------------------------------------------------------------------------
        */

        $dogCages = Cage::whereRaw(
            'LOWER(animal_type) = ?',
            ['dog']
        )->count();


        /*
        |--------------------------------------------------------------------------
        | CAT CAGES
        |--------------------------------------------------------------------------
        */

        $catCages = Cage::whereRaw(
            'LOWER(animal_type) = ?',
            ['cat']
        )->count();


        /*
        |--------------------------------------------------------------------------
        | 6. DOG OCCUPANCY
        |--------------------------------------------------------------------------
        */

        $dogOccupied = Animal::whereHas(
            'cage',
            function ($query) {

                $query->whereRaw(
                    'LOWER(animal_type) = ?',
                    ['dog']
                );

            }
        )->count();


        /*
        |--------------------------------------------------------------------------
        | 7. CAT OCCUPANCY
        |--------------------------------------------------------------------------
        */

        $catOccupied = Animal::whereHas(
            'cage',
            function ($query) {

                $query->whereRaw(
                    'LOWER(animal_type) = ?',
                    ['cat']
                );

            }
        )->count();


        /*
        |--------------------------------------------------------------------------
        | 8. TOTAL CAPACITY
        |--------------------------------------------------------------------------
        |
        | Your cage condition:
        |
        | Dog = 140 cages × 5 = 700
        | Cat = 20 cages × 5 = 100
        |
        */

        $dogTotalSlots = $dogCages * 5;

        $catTotalSlots = $catCages * 5;


        /*
        |--------------------------------------------------------------------------
        | 9. AVAILABLE SLOTS
        |--------------------------------------------------------------------------
        */

        $dogAvailable = max(
            $dogTotalSlots - $dogOccupied,
            0
        );


        $catAvailable = max(
            $catTotalSlots - $catOccupied,
            0
        );


        /*
        |--------------------------------------------------------------------------
        | 10. SELECTED CAGE
        |--------------------------------------------------------------------------
        |
        | When the administrator clicks a cage,
        | the URL becomes something like:
        |
        | /admin/cages?type=dog&cage=1
        |
        */

        $selectedCage = null;


        if ($request->filled('cage')) {

            $selectedCage = Cage::with('animals')
                ->find(
                    $request->query('cage')
                );

        }


        /*
        |--------------------------------------------------------------------------
        | 11. SEND DATA TO BLADE
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.animal-cages',
            compact(

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

            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE / ADD CAGE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATE FORM
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'cage_number' => [
                'required',
                'string',
                'max:50',
                'unique:cages,cage_number',
            ],

            'animal_type' => [
                'required',
                'in:Dog,Cat',
            ],

            'capacity' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],

            'status' => [
                'required',
                'in:Available,Maintenance',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | CREATE CAGE
        |--------------------------------------------------------------------------
        */

        Cage::create($validated);


        /*
        |--------------------------------------------------------------------------
        | RETURN TO CAGE MANAGEMENT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.cages')
            ->with(
                'success',
                'Cage ' .
                $validated['cage_number'] .
                ' was created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE CAGE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {

        /*
        |--------------------------------------------------------------------------
        | FIND CAGE
        |--------------------------------------------------------------------------
        */

        $cage = Cage::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | VALIDATE
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'cage_number' => [
                'required',
                'string',
                'max:50',

                'unique:cages,cage_number,' .
                $cage->id,
            ],

            'animal_type' => [
                'required',
                'in:Dog,Cat',
            ],

            'capacity' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],

            'status' => [
                'required',
                'in:Available,Maintenance',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | CHECK CURRENT OCCUPANCY
        |--------------------------------------------------------------------------
        */

        $occupied =
            $cage->animals()->count();


        /*
        |--------------------------------------------------------------------------
        | DON'T ALLOW CAPACITY BELOW OCCUPANCY
        |--------------------------------------------------------------------------
        |
        | Example:
        |
        | Current cage = 3 animals
        |
        | Admin cannot change capacity from 5 to 2.
        |
        */

        if (
            $validated['capacity'] <
            $occupied
        ) {

            return back()
                ->withErrors([

                    'capacity' =>
                        "This cage currently contains "
                        . $occupied
                        . " animal(s). "
                        . "Capacity cannot be lower "
                        . "than the current occupancy.",

                ])
                ->withInput();

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $cage->update(
            $validated
        );


        /*
        |--------------------------------------------------------------------------
        | RETURN TO PAGE
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.cages',
                [
                    'type' =>
                        strtolower(
                            $cage->animal_type
                        ),

                    'cage' =>
                        $cage->id,
                ]
            )
            ->with(
                'success',
                'Cage updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW CAGE DETAILS
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        /*
        |--------------------------------------------------------------------------
        | FIND CAGE WITH ANIMALS
        |--------------------------------------------------------------------------
        */

        $cage = Cage::with(
            'animals'
        )->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | OCCUPANCY
        |--------------------------------------------------------------------------
        */

        $occupied =
            $cage->animals->count();


        /*
        |--------------------------------------------------------------------------
        | AVAILABLE
        |--------------------------------------------------------------------------
        */

        $available = max(
            $cage->capacity -
            $occupied,
            0
        );


        /*
        |--------------------------------------------------------------------------
        | RETURN JSON
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'id' =>
                $cage->id,

            'cage_number' =>
                $cage->cage_number,

            'animal_type' =>
                $cage->animal_type,

            'capacity' =>
                $cage->capacity,

            'occupied' =>
                $occupied,

            'available' =>
                $available,

            'status' =>
                $cage->status ??
                'Available',

            'animals' =>
                $cage->animals->map(
                    function ($animal) {

                        return [

                            'id' =>
                                $animal->id,

                            'name' =>
                                $animal->name,

                            'breed' =>
                                $animal->breed,

                            'animal_image' =>
                                $animal->animal_image,

                        ];

                    }
                ),

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE CAGE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        /*
        |--------------------------------------------------------------------------
        | FIND CAGE
        |--------------------------------------------------------------------------
        */

        $cage =
            Cage::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | DON'T DELETE A CAGE WITH ANIMALS
        |--------------------------------------------------------------------------
        */

        if (
            $cage->animals()->exists()
        ) {

            return back()
                ->withErrors([

                    'cage' =>
                        'This cage cannot be deleted because '
                        . 'it still contains animals.',

                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | DELETE
        |--------------------------------------------------------------------------
        */

        $cage->delete();


        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.cages'
            )
            ->with(
                'success',
                'Cage deleted successfully.'
            );
    }
}