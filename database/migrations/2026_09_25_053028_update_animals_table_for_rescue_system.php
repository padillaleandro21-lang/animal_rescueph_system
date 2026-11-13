<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('animals', function (Blueprint $table) {

            // Rename existing columns
            $table->renameColumn('image', 'animal_image');
            $table->renameColumn('description', 'additional_notes');

            // Animal measurements
            $table->decimal('weight', 8, 2)->nullable()->after('gender');
            $table->decimal('height', 8, 2)->nullable()->after('weight');

            // Rescue source
            $table->string('source_type')->nullable()->after('animal_image');

            // Related rescue report
            $table->foreignId('report_id')
                ->nullable()
                ->after('source_type')
                ->constrained('animal_reports')
                ->nullOnDelete();

            // Rescue information
            $table->date('date_acquired')
                ->nullable()
                ->after('report_id');

            $table->text('location_found')
                ->nullable()
                ->after('date_acquired');

            // Health information
            $table->string('health_condition')
                ->nullable()
                ->after('location_found');

            $table->text('medical_notes')
                ->nullable()
                ->after('health_condition');

            // Vaccination records
            $table->json('vaccinations')
                ->nullable()
                ->after('medical_notes');

            // Cage assignment
            $table->foreignId('cage_id')
                ->nullable()
                ->after('status')
                ->constrained('cages')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {

            $table->dropForeign(['report_id']);
            $table->dropForeign(['cage_id']);

            $table->dropColumn([
                'weight',
                'height',
                'source_type',
                'report_id',
                'date_acquired',
                'location_found',
                'health_condition',
                'medical_notes',
                'vaccinations',
                'cage_id',
            ]);

            $table->renameColumn('animal_image', 'image');
            $table->renameColumn('additional_notes', 'description');
        });
    }
};