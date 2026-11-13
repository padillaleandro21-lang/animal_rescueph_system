<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('animal_reports', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)
                ->nullable()
                ->after('house_street');

            $table->decimal('longitude', 10, 7)
                ->nullable()
                ->after('latitude');
        });
    }

    public function down(): void
    {
        Schema::table('animal_reports', function (Blueprint $table) {
            $table->dropColumn([
                'latitude',
                'longitude'
            ]);
        });
    }
};