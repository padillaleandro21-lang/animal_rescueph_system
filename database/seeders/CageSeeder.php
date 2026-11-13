<?php

namespace Database\Seeders;

use App\Models\Cage;
use Illuminate\Database\Seeder;

class CageSeeder extends Seeder
{
    /**
     * Create the complete cage inventory.
     *
     * Dogs:
     * D-001 to D-140
     *
     * Cats:
     * C-001 to C-020
     *
     * Capacity:
     * 5 animals per cage
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | DOG CAGES
        |--------------------------------------------------------------------------
        */

        for ($number = 1; $number <= 140; $number++) {

            $cageNumber =
                'D-' . str_pad(
                    $number,
                    3,
                    '0',
                    STR_PAD_LEFT
                );

            Cage::firstOrCreate(
                [
                    'cage_number' => $cageNumber,
                ],
                [
                    'animal_type' => 'Dog',
                    'capacity' => 5,
                    'status' => 'Available',
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CAT CAGES
        |--------------------------------------------------------------------------
        */

        for ($number = 1; $number <= 20; $number++) {

            $cageNumber =
                'C-' . str_pad(
                    $number,
                    3,
                    '0',
                    STR_PAD_LEFT
                );

            Cage::firstOrCreate(
                [
                    'cage_number' => $cageNumber,
                ],
                [
                    'animal_type' => 'Cat',
                    'capacity' => 5,
                    'status' => 'Available',
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | RESULT
        |--------------------------------------------------------------------------
        */

        $dogCount =
            Cage::where('animal_type', 'Dog')
                ->count();

        $catCount =
            Cage::where('animal_type', 'Cat')
                ->count();

        $totalCount =
            Cage::count();


        $this->command->info(
            "Dog cages: {$dogCount}"
        );

        $this->command->info(
            "Cat cages: {$catCount}"
        );

        $this->command->info(
            "Total cages: {$totalCount}"
        );

        $this->command->info(
            'Cage seeding completed successfully.'
        );
    }
}