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
        Schema::create('jerseys', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Jersey template name (e.g., "Home Kit 2024", "Away Kit 2024")
            $table->string('type'); // 'home', 'away', 'third', 'special'
            $table->string('season'); // e.g., "2024/25"
            $table->string('template_image'); // Path to the base jersey template image
            $table->json('customization_options'); // Available customization options
            $table->decimal('price', 8, 2)->default(0); // Price for customization
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index(['type', 'is_active']);
            $table->index('season');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jerseys');
    }
};
