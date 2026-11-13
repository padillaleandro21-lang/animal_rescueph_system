<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | CREATE TABLE
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        Schema::create('animal_reports', function (Blueprint $table) {

            // Report ID
            $table->id();


            // ==========================================
            // REPORTER INFORMATION
            // ==========================================

            $table->string('full_name');

            $table->string('email');

            $table->string('contact_number');


            // ==========================================
            // LOCATION
            // ==========================================

            $table->string('province');

            $table->string('city_municipality');

            $table->string('barangay');

            $table->string('house_street');


            // ==========================================
            // ANIMAL INFORMATION
            // ==========================================

            $table->string('animal_image')->nullable();

            $table->string('animal_type')->nullable();

            $table->string('breed')->nullable();


            // ==========================================
            // ADDITIONAL INFORMATION
            // ==========================================

            $table->text('additional_notes')->nullable();


            // ==========================================
            // REPORT STATUS
            // ==========================================

            $table->enum('status', [
                'Pending',
                'Under Review',
                'Approved',
                'Rejected'
            ])->default('Pending');


            // Created / Updated
            $table->timestamps();
        });
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE TABLE
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {
        Schema::dropIfExists('animal_reports');
    }
};