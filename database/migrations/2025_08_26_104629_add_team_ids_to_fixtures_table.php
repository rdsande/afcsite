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
            // Add foreign key columns for teams
            $table->foreignId('home_team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->foreignId('away_team_id')->nullable()->constrained('teams')->onDelete('cascade');
            
            // Add missing columns that the model expects
            $table->string('stadium')->nullable()->after('venue');
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();
            $table->text('match_report')->nullable();
            $table->integer('attendance')->nullable();
            $table->string('referee')->nullable();
            $table->json('team_lineups')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('broadcast_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->dropForeign(['home_team_id']);
            $table->dropForeign(['away_team_id']);
            $table->dropColumn([
                'home_team_id',
                'away_team_id',
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
        });
    }
};
