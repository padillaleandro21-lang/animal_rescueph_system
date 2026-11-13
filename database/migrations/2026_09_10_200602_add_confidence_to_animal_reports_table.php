<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('animal_reports', function (Blueprint $table) {

            $table->decimal(
                'confidence',
                5,
                2
            )->nullable()->after('breed');

        });
    }


    public function down(): void
    {
        Schema::table('animal_reports', function (Blueprint $table) {

            $table->dropColumn('confidence');

        });
    }
};