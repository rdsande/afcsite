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
        Schema::table('players', function (Blueprint $table) {
            // Goals statistics
            $table->integer('goals_inside_box')->default(0);
            $table->integer('goals_outside_box')->default(0);
            
            // Attacking statistics (passes)
            $table->integer('passes_completed')->default(0);
            $table->integer('passes_lost')->default(0);
            
            // Defending statistics
            $table->integer('tackles_won')->default(0);
            $table->integer('tackles_lost')->default(0);
            $table->integer('interceptions')->default(0);
            $table->integer('clearances')->default(0);
            $table->integer('blocks')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn([
                'goals_inside_box',
                'goals_outside_box',
                'passes_completed',
                'passes_lost',
                'tackles_won',
                'tackles_lost',
                'interceptions',
                'clearances',
                'blocks'
            ]);
        });
    }
};
