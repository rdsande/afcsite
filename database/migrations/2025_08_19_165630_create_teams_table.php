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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name', 10)->nullable();
            $table->string('logo')->nullable();
            $table->string('home_stadium')->nullable();
            $table->integer('founded_year')->nullable();
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->json('social_media')->nullable();
            $table->string('primary_color', 7)->nullable(); // Hex color
            $table->string('secondary_color', 7)->nullable(); // Hex color
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['name', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
