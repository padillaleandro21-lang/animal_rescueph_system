<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adoptions', function (Blueprint $table) {

            $table->id();

            // User who submitted the adoption
            $table->unsignedBigInteger('user_id')->nullable();

            // Animal being adopted
            $table->unsignedBigInteger('animal_id')->nullable();

            // Adoption application status
            $table->string('status')->default('Pending');

            // Optional notes
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adoptions');
    }
};