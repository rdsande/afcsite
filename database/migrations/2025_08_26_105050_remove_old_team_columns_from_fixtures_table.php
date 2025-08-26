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
            // Drop old string-based team columns
            $table->dropColumn([
                'home_team',
                'away_team',
                'home_team_logo',
                'away_team_logo',
                'venue', // replaced by stadium
                'ticket_link',
                'ticket_price',
                'is_home' // not needed with proper team relationships
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fixtures', function (Blueprint $table) {
            // Restore old columns if needed
            $table->string('home_team')->default('AZAM FC');
            $table->string('away_team');
            $table->string('home_team_logo')->nullable();
            $table->string('away_team_logo')->nullable();
            $table->string('venue');
            $table->string('ticket_link')->nullable();
            $table->decimal('ticket_price', 10, 0)->nullable();
            $table->boolean('is_home')->default(true);
        });
    }
};
