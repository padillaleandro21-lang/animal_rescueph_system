<?php

namespace App\Http\Controllers;

use App\Models\AnimalReport;
use App\Services\NyckelService;
use Illuminate\Http\Request;
use Exception;

class ReportAnimalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW REPORT ANIMAL PAGE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('report-animal', [
            'imagePath' => null,
            'animalType' => null,
            'breed' => null,
            'confidence' => null,
            'detectionRejected' => false,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DETECT ANIMAL BREED
    |--------------------------------------------------------------------------
    */
    public function detect(Request $request, NyckelService $nyckel)
    {
        /*
        IMPORTANT:
        This is the FIRST form.

        The user is uploading an actual image file,
        so the validation MUST use image/mimes,
        NOT string.
        */
        $request->validate([
            'animal_image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        try {

            /*
            |--------------------------------------------------------------------------
            | CREATE UPLOAD FOLDER
            |--------------------------------------------------------------------------
            */

            $uploadPath = public_path('uploads/animals');

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }


            /*
            |--------------------------------------------------------------------------
            | SAVE IMAGE
            |--------------------------------------------------------------------------
            */

            $imageName =
                time() . '_' .
                $request->file('animal_image')->getClientOriginalName();

            $request->file('animal_image')->move(
                $uploadPath,
                $imageName
            );

            $imagePath = $uploadPath . '/' . $imageName;


            /*
            |--------------------------------------------------------------------------
            | SEND IMAGE TO NYCKEL
            |--------------------------------------------------------------------------
            */

            $result = $nyckel->detectBreed($imagePath);

            $confidence = floatval(
                $result['confidence'] ?? 0
            );

            $animalType = $result['animal_type'] ?? 'Unknown';
            $breed = $result['breed'] ?? 'Unknown';


            /*
            |--------------------------------------------------------------------------
            | 50% ACCURACY RULE
            |--------------------------------------------------------------------------
            |
            | BELOW 50% = REJECTED
            |
            | 49% = rejected
            | 40% = rejected
            | 20% = rejected
            |
            | 50% = accepted
            | 51% = accepted
            | 80% = accepted
            |
            */

            if ($confidence < 50) {

                return view('report-animal', [
                    'imagePath' => $imageName,
                    'animalType' => $animalType,
                    'breed' => $breed,
                    'confidence' => $confidence,
                    'detectionRejected' => true,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | DETECTION ACCEPTED
            |--------------------------------------------------------------------------
            */

            return view('report-animal', [
                'imagePath' => $imageName,
                'animalType' => $animalType,
                'breed' => $breed,
                'confidence' => $confidence,
                'detectionRejected' => false,
            ]);

        } catch (Exception $e) {

    return back()
        ->withErrors([
            'animal_image' =>
                'Breed detection failed: ' . $e->getMessage()
        ])
        ->withInput();
}
    }


    /*
    |--------------------------------------------------------------------------
    | STORE ANIMAL REPORT
    |--------------------------------------------------------------------------
    */
   public function store(Request $request)
{
    $validated = $request->validate(
        [

            'first_name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[A-Za-zÀ-ÿ]+(?:[ -][A-Za-zÀ-ÿ]+)*$/'
            ],

            'last_name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[A-Za-zÀ-ÿ]+(?:[ -][A-Za-zÀ-ÿ]+)*$/'
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'ends_with:@gmail.com'
            ],

            'contact_number' => [
                'required',
                'regex:/^09[0-9]{9}$/'
            ],

            'region' => [
                'required',
                'string'
            ],

            'province' => [
                'required',
                'string'
            ],

            'city_municipality' => [
                'required',
                'string'
            ],

            'barangay' => [
                'required',
                'string'
            ],

            'house_street' => [
                'required',
                'string',
                'max:255'
            ],

            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90'
            ],

            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180'
            ],

            'animal_image' => [
                'required',
                'string',
                'max:255'
            ],

            'animal_type' => [
                'required',
                'string'
            ],

            'breed' => [
                'nullable',
                'string'
            ],

            'confidence' => [
                'required',
                'numeric',
                'min:50'
            ],

            'additional_notes' => [
                'nullable',
                'string'
            ],

            'terms_privacy' => [
    'accepted'
],
        ],

        // Custom validation messages
        [
            'house_street.required' =>
                'Please enter the House Number / Street before submitting the animal report.',

            'first_name.regex' =>
                'Please enter a valid first name.',

            'last_name.regex' =>
                'Please enter a valid last name.',

            'email.ends_with' =>
                'Please use a Gmail address ending with @gmail.com.',

            'contact_number.regex' =>
                'Please enter a valid Philippine contact number, example: 09123456789.',
        ]
    );


    // ------------------------------------------
    // CONFIDENCE PROTECTION
    // ------------------------------------------

    if ((float) $validated['confidence'] < 50) {

        return back()
            ->withErrors([
                'animal_image' =>
                    'Please upload a clearer animal photo and detect again.'
            ])
            ->withInput();
    }


    // ------------------------------------------
    // SAVE REPORT
    // ------------------------------------------

    AnimalReport::create([

        'first_name' =>
            trim($validated['first_name']),

        'last_name' =>
            trim($validated['last_name']),

        'email' =>
            strtolower(trim($validated['email'])),

        'contact_number' =>
            $validated['contact_number'],

        'region' =>
            $validated['region'],

        'province' =>
            $validated['province'],

        'city_municipality' =>
            $validated['city_municipality'],

        'barangay' =>
            $validated['barangay'],

        'house_street' =>
            $validated['house_street'],

        'latitude' =>
            $validated['latitude'] ?? null,

        'longitude' =>
            $validated['longitude'] ?? null,

        'animal_image' =>
            $validated['animal_image'],

        'animal_type' =>
            $validated['animal_type'],

        'breed' =>
            $validated['breed'] ?? null,

        'confidence' =>
            $validated['confidence'],

        'additional_notes' =>
            $validated['additional_notes'] ?? null,

        'status' =>
            'Pending',
    ]);


    // ------------------------------------------
    // SUCCESS
    // ------------------------------------------

    return redirect()
        ->route('report-animal')
        ->with(
            'success',
            'Animal report submitted successfully.'
        );
}
}