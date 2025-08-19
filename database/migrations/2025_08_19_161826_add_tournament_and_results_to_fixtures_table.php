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
            $table->foreignId('tournament_id')->nullable()->constrained()->onDelete('set null');
            $table->string('stadium')->nullable()->after('venue'); // Stadium name
            $table->integer('home_score')->nullable(); // Final home team score
            $table->integer('away_score')->nullable(); // Final away team score
            $table->text('match_report')->nullable(); // Post-match report
            $table->integer('attendance')->nullable(); // Match attendance
            $table->string('referee')->nullable(); // Match referee
            $table->json('team_lineups')->nullable(); // Starting lineups for both teams
            $table->boolean('is_featured')->default(false); // Featured match
            $table->string('broadcast_link')->nullable(); // Live stream or broadcast link
            
            // Rename competition to competition_type for consistency
            $table->renameColumn('competition', 'competition_type');
            
            $table->index(['tournament_id', 'match_date']);
            $table->index(['is_featured', 'match_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->dropForeign(['tournament_id']);
            $table->dropColumn([
                'tournament_id',
                'stadium',
                'home_score',
                'away_score',
                'match_report',
                'attendance',
                'referee',
                'team_lineups',
                'is_featured',
                'broadcast_link'
            ]);
            
            $table->renameColumn('competition_type', 'competition');
            
            $table->dropIndex(['tournament_id', 'match_date']);
            $table->dropIndex(['is_featured', 'match_date']);
        });
    }
};
