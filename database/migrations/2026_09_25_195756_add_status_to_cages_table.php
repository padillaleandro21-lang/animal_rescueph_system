<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cages', function (Blueprint $table) {

            $table->enum(
                'status',
                ['Available', 'Maintenance']
            )
            ->default('Available')
            ->after('capacity');

        });
    }


    public function down(): void
    {
        Schema::table('cages', function (Blueprint $table) {

            $table->dropColumn('status');

        });
    }
};