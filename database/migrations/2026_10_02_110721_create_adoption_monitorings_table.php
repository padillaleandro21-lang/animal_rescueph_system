<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adoption_monitorings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('adoption_application_id')
                ->constrained('adoption_applications')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('week_number');

            $table->date('monitoring_date');

            $table->boolean('animal_condition')
                ->default(false);

            $table->boolean('food_water')
                ->default(false);

            $table->boolean('shelter_condition')
                ->default(false);

            $table->boolean('care_compliance')
                ->default(false);

            $table->text('notes')
                ->nullable();

            $table->string('status')
                ->default('Pending');

            $table->timestamps();

            $table->unique([
                'adoption_application_id',
                'week_number'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adoption_monitorings');
    }
};