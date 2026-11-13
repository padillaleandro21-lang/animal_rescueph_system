<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adoption_applications', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATIONSHIPS
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('animal_id')
                ->constrained('animals')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | APPLICANT INFORMATION SNAPSHOT
            |--------------------------------------------------------------------------
            */

            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 255);
            $table->string('contact_number', 20);

            $table->string('occupation', 100);
            $table->string('civil_status', 50);


            /*
            |--------------------------------------------------------------------------
            | ADDRESS
            |--------------------------------------------------------------------------
            */

            $table->string('house_street', 255);
            $table->string('region', 150);
            $table->string('province', 150);
            $table->string('city_municipality', 150);
            $table->string('barangay', 150);
            $table->string('zip_code', 20)->nullable();


            /*
            |--------------------------------------------------------------------------
            | ADOPTION BACKGROUND
            |--------------------------------------------------------------------------
            */

            $table->string('reason_for_adoption', 100);

            $table->text('reason_explanation')
                ->nullable();

            $table->string('primary_responsible', 100);

            $table->string('primary_responsible_other', 255)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | HOUSEHOLD INFORMATION
            |--------------------------------------------------------------------------
            */

            $table->string('residence_type', 100);

            $table->string('residence_other', 255)
                ->nullable();

            $table->string('landlord_permission', 50);

            $table->unsignedInteger('household_members');

            $table->string('household_support', 20);


            /*
            |--------------------------------------------------------------------------
            | ADOPTION COMMITMENT
            |--------------------------------------------------------------------------
            */

            $table->boolean('commitment_food_shelter_care')
                ->default(false);

            $table->boolean('commitment_veterinary_care')
                ->default(false);

            $table->boolean('commitment_safety')
                ->default(false);

            $table->boolean('commitment_policies')
                ->default(false);

            $table->boolean('commitment_post_adoption')
                ->default(false);


            /*
            |--------------------------------------------------------------------------
            | IDENTIFICATION DOCUMENT
            |--------------------------------------------------------------------------
            */

            $table->string('valid_id_path');

            $table->string('valid_id_original_name')
                ->nullable();

            /*
            | pending = waiting for admin verification
            | verified = accepted
            | rejected = invalid/unacceptable
            */

            $table->string('id_verification_status')
                ->default('pending');


            /*
            |--------------------------------------------------------------------------
            | APPLICATION STATUS
            |--------------------------------------------------------------------------
            */

            $table->string('status')
                ->default('Pending');

            /*
            | Pending
            | Approved
            | Rejected
            | Adopted
            | Completed
            */

            $table->text('admin_notes')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | AGREEMENTS
            |--------------------------------------------------------------------------
            */

            $table->boolean('agreement_information')
                ->default(false);

            $table->boolean('agreement_not_automatic')
                ->default(false);

            $table->boolean('agreement_policies')
                ->default(false);


            $table->timestamp('submitted_at')
                ->nullable();

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | PREVENT DUPLICATE PENDING APPLICATION
            |--------------------------------------------------------------------------
            */

            $table->index([
                'user_id',
                'animal_id',
                'status'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adoption_applications');
    }
};