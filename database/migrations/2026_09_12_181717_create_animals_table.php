<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('animal_type');

            $table->string('breed')->nullable();

            $table->string('gender')->nullable();

            $table->string('age')->nullable();

            $table->string('image')->nullable();

            $table->string('status')->default('Registered');

            $table->text('description')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};