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
        // Skip this migration for now to avoid conflicts
        // This will be handled in a future migration
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('fixtures')) {
            Schema::table('fixtures', function (Blueprint $table) {
                // Remove team relationships if they exist
                try {
                    $table->dropForeign(['home_team_id']);
                    $table->dropForeign(['away_team_id']);
                } catch (Exception $e) {
                    // Foreign keys may not exist
                }
                
                if (Schema::hasColumn('fixtures', 'home_team_id')) {
                    $table->dropColumn('home_team_id');
                }
                if (Schema::hasColumn('fixtures', 'away_team_id')) {
                    $table->dropColumn('away_team_id');
                }
                
                // Add back team fields if they don't exist
                if (!Schema::hasColumn('fixtures', 'home_team')) {
                    $table->string('home_team')->default('AZAM FC');
                }
                if (!Schema::hasColumn('fixtures', 'away_team')) {
                    $table->string('away_team');
                }
                if (!Schema::hasColumn('fixtures', 'home_team_logo')) {
                    $table->string('home_team_logo')->nullable();
                }
                if (!Schema::hasColumn('fixtures', 'away_team_logo')) {
                    $table->string('away_team_logo')->nullable();
                }
                
                // Remove indexes if they exist
                try {
                    $table->dropIndex(['home_team_id', 'away_team_id']);
                    $table->dropIndex(['match_date', 'home_team_id']);
                } catch (Exception $e) {
                    // Indexes may not exist
                }
            });
        }
    }
};
