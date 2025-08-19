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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('jersey_number')->nullable();
            $table->string('position'); // goalkeeper, defender, midfielder, forward
            $table->string('team_category'); // senior, u20, u17, u15, u13
            $table->date('date_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->decimal('height', 5, 2)->nullable(); // in meters
            $table->decimal('weight', 5, 2)->nullable(); // in kg
            $table->string('preferred_foot')->nullable(); // left, right, both
            $table->string('profile_image')->nullable();
            $table->text('biography')->nullable();
            $table->date('joined_date')->nullable();
            $table->string('previous_club')->nullable();
            $table->integer('goals')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('appearances')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_captain')->default(false);
            $table->timestamps();
            
            $table->index(['team_category', 'is_active']);
            $table->index(['position', 'team_category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
