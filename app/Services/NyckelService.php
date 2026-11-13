<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class NyckelService
{
    public function detectBreed(string $imagePath): array
    {
        /*
        |--------------------------------------------------------------------------
        | 1. GET NYCKEL TOKEN
        |--------------------------------------------------------------------------
        */

        $tokenResponse = Http::withoutVerifying()
            ->asForm()
            ->timeout(30)
            ->post(
                'https://www.nyckel.com/connect/token',
                [
                    'client_id' => env('NYCKEL_CLIENT_ID'),
                    'client_secret' => env('NYCKEL_CLIENT_SECRET'),
                    'grant_type' => 'client_credentials',
                ]
            );

        if (!$tokenResponse->successful()) {
            throw new Exception(
                'Unable to connect to Nyckel.'
            );
        }

        $tokenData = $tokenResponse->json();

        $accessToken = $tokenData['access_token'] ?? null;

        if (!$accessToken) {
            throw new Exception(
                'Nyckel access token was not received.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 2. SEND IMAGE TO NYCKEL
        |--------------------------------------------------------------------------
        */

        $response = Http::withoutVerifying()
            ->withToken($accessToken)
            ->timeout(60)
            ->attach(
                'data',
                file_get_contents($imagePath),
                basename($imagePath)
            )
            ->post(
                'https://www.nyckel.com/v1/functions/'
                . env('NYCKEL_FUNCTION_ID')
                . '/invoke'
            );

        if (!$response->successful()) {
            throw new Exception(
                'Nyckel failed to analyze the image.'
            );
        }

        $result = $response->json();


        /*
        |--------------------------------------------------------------------------
        | 3. GET AI RESULT
        |--------------------------------------------------------------------------
        */

        $label = $result['labelName'] ?? 'Unknown';

        $confidence = $result['confidence'] ?? 0;

        $confidence = floatval($confidence);

        // Convert 0.95 to 95
        if ($confidence <= 1) {
            $confidence = $confidence * 100;
        }

        $confidence = round($confidence, 2);


     /*
|--------------------------------------------------------------------------
| 4. DETERMINE ANIMAL TYPE AND BREED
|--------------------------------------------------------------------------
*/

$animalType = 'Unknown';
$breed = 'Unknown';

$cleanLabel = trim($label);

/*
|--------------------------------------------------------------------------
| KNOWN CAT BREEDS
|--------------------------------------------------------------------------
*/

$catBreeds = [
    'persian',
    'siamese',
    'maine coon',
    'ragdoll',
    'british shorthair',
    'american shorthair',
    'scottish fold',
    'bengal',
    'sphynx',
    'russian blue',
    'birman',
    'abyssinian',
    'exotic shorthair'
];

/*
|--------------------------------------------------------------------------
| KNOWN DOG BREEDS
|--------------------------------------------------------------------------
*/

$dogBreeds = [
    'aspin',
    'philippine aspin',
    'philippine native dog',
    'mixed breed',
    'labrador',
    'labrador retriever',
    'golden retriever',
    'german shepherd',
    'german shepherd dog',
    'poodle',
    'chihuahua',
    'shih tzu',
    'beagle',
    'bulldog',
    'french bulldog',
    'pomeranian',
    'husky',
    'siberian husky',
    'rottweiler',
    'doberman',
    'dachshund',
    'dalmatian',
    'boxer',
    'great dane',
    'corgi',
    'border collie',
    'jack russell',
    'pitbull',
    'american pit bull terrier',
    'terrier',
    'spaniel',
    'pug',
    'maltese',
    'akita',
    'shiba inu',
    'yorkshire terrier',
    'yorkie'
];

/*
|--------------------------------------------------------------------------
| STEP 1: CHECK CAT BREEDS FIRST
|--------------------------------------------------------------------------
|
| Persian MUST be recognized as CAT.
|
*/

foreach ($catBreeds as $catBreed) {

    if (stripos($cleanLabel, $catBreed) !== false) {

        $animalType = 'Cat';

        // Use the detected breed name
        $breed = ucwords($catBreed);

        break;
    }
}

/*
|--------------------------------------------------------------------------
| STEP 2: CHECK DOG BREEDS
|--------------------------------------------------------------------------
*/

if ($animalType === 'Unknown') {

    foreach ($dogBreeds as $dogBreed) {

        if (stripos($cleanLabel, $dogBreed) !== false) {

            $animalType = 'Dog';

            $breed = ucwords($dogBreed);

            break;
        }
    }
}

/*
|--------------------------------------------------------------------------
| STEP 3: CHECK EXPLICIT CAT LABEL
|--------------------------------------------------------------------------
*/

if ($animalType === 'Unknown') {

    if (preg_match('/\bcat\b/i', $cleanLabel)) {

        $animalType = 'Cat';

        $breed = preg_replace(
            '/^\s*cat\s*[-:]?\s*/i',
            '',
            $cleanLabel
        );

        $breed = trim($breed);

        if ($breed === '') {
            $breed = 'Unknown';
        }
    }
}

/*
|--------------------------------------------------------------------------
| STEP 4: CHECK EXPLICIT DOG LABEL
|--------------------------------------------------------------------------
*/

if ($animalType === 'Unknown') {

    if (preg_match('/\bdog\b/i', $cleanLabel)) {

        $animalType = 'Dog';

        $breed = preg_replace(
            '/^\s*dog\s*[-:]?\s*/i',
            '',
            $cleanLabel
        );

        $breed = trim($breed);

        if ($breed === '') {
            $breed = 'Unknown';
        }
    }
}
        /*
        |--------------------------------------------------------------------------
        | 5. CONFIDENCE THRESHOLD
        |--------------------------------------------------------------------------
        */
/*
|--------------------------------------------------------------------------
| 5. CONFIDENCE HANDLING
|--------------------------------------------------------------------------
|
| IMPORTANT:
| Breed confidence should NOT change the detected animal type.
|
| Example:
| Confidence = 30.9%
| Animal Type = Dog
|
| The system will keep "Dog" but mark the breed as uncertain.
|--------------------------------------------------------------------------
*/
if ($confidence < 50) {

    if ($animalType === 'Dog') {

        $breed = $breed !== 'Unknown'
            ? 'Possible ' . $breed
            : 'Breed Uncertain';

    } elseif ($animalType === 'Cat') {

        $breed = $breed !== 'Unknown'
            ? 'Possible ' . $breed
            : 'Breed Uncertain';

    } else {

        $breed = 'Unknown';
    }
}
        /*
        |--------------------------------------------------------------------------
        | 6. RETURN RESULT
        |--------------------------------------------------------------------------
        */

        return [
            'animal_type' => $animalType,
            'breed' => $breed,
            'confidence' => $confidence,
            'label' => $label,
        ];
    }
}