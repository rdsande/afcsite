<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class UpdateFixtureTeamIds extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all teams for mapping
        $teams = Team::all()->keyBy('name');
        
        // Get all fixtures that need updating
        $fixtures = Fixture::whereNull('home_team_id')
                          ->orWhereNull('away_team_id')
                          ->get();
        
        foreach ($fixtures as $fixture) {
            $homeTeamId = null;
            $awayTeamId = null;
            
            // Find home team ID
            if ($fixture->home_team) {
                $homeTeam = $teams->get($fixture->home_team);
                if (!$homeTeam) {
                    // Try partial match for variations like "AZAM FC" vs "Azam FC"
                    $homeTeam = $teams->first(function ($team) use ($fixture) {
                        return stripos($team->name, $fixture->home_team) !== false ||
                               stripos($fixture->home_team, $team->name) !== false;
                    });
                }
                $homeTeamId = $homeTeam ? $homeTeam->id : null;
            }
            
            // Find away team ID
            if ($fixture->away_team) {
                $awayTeam = $teams->get($fixture->away_team);
                if (!$awayTeam) {
                    // Try partial match for variations
                    $awayTeam = $teams->first(function ($team) use ($fixture) {
                        return stripos($team->name, $fixture->away_team) !== false ||
                               stripos($fixture->away_team, $team->name) !== false;
                    });
                }
                $awayTeamId = $awayTeam ? $awayTeam->id : null;
            }
            
            // Update the fixture with team IDs
            if ($homeTeamId || $awayTeamId) {
                $fixture->update([
                    'home_team_id' => $homeTeamId,
                    'away_team_id' => $awayTeamId
                ]);
                
                $this->command->info("Updated fixture {$fixture->id}: {$fixture->home_team} (ID: {$homeTeamId}) vs {$fixture->away_team} (ID: {$awayTeamId})");
            } else {
                $this->command->warn("Could not find teams for fixture {$fixture->id}: {$fixture->home_team} vs {$fixture->away_team}");
            }
        }
        
        $this->command->info('Fixture team IDs updated successfully!');
    }
}
