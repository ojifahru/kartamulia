<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departements', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade');
            $table->string('accreditation')->nullable();
            $table->json('description')->nullable();
            $table->json('vision')->nullable();
            $table->json('mission')->nullable();
            $table->json('objectives')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departements');
    }
};
