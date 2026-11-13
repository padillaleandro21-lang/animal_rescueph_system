<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('animal_reports', function (Blueprint $table) {

            $table->string('first_name')
                ->after('id');

            $table->string('last_name')
                ->after('first_name');

            $table->dropColumn('full_name');

        });
    }

    public function down(): void
    {
        Schema::table('animal_reports', function (Blueprint $table) {

            $table->string('full_name')
                ->after('id');

            $table->dropColumn([
                'first_name',
                'last_name'
            ]);

        });
    }
};