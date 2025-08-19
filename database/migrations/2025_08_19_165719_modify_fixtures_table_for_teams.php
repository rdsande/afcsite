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
        Schema::table('fixtures', function (Blueprint $table) {
            // Add foreign key constraints to existing team_id columns
            $table->foreign('home_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('away_team_id')->references('id')->on('teams')->onDelete('cascade');
            
            // Remove old team fields
            $table->dropColumn(['home_team', 'away_team', 'home_team_logo', 'away_team_logo']);
            
            // Add indexes for better performance
            $table->index(['home_team_id', 'away_team_id']);
            $table->index(['match_date', 'home_team_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fixtures', function (Blueprint $table) {
            // Remove team relationships
            $table->dropForeign(['home_team_id']);
            $table->dropForeign(['away_team_id']);
            $table->dropColumn(['home_team_id', 'away_team_id']);
            
            // Add back team fields
            $table->string('home_team')->default('AZAM FC');
            $table->string('away_team');
            $table->string('home_team_logo')->nullable();
            $table->string('away_team_logo')->nullable();
            
            // Remove indexes
            $table->dropIndex(['home_team_id', 'away_team_id']);
            $table->dropIndex(['match_date', 'home_team_id']);
        });
    }
};
