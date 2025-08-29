<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Fixture;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FixtureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if we have the required teams
        $azamTeam = Team::where('name', 'Azam FC')->first();
        $simbaTeam = Team::where('name', 'Simba SC')->first();
        $yangaTeam = Team::where('name', 'Young Africans SC')->first();
        $kageraTeam = Team::where('name', 'Kagera Sugar FC')->first();
        $coastalTeam = Team::where('name', 'Coastal Union FC')->first();
        
        if (!$azamTeam || !$simbaTeam || !$yangaTeam) {
            $this->command->info('Required teams not found. Please run TeamsTableSeeder first.');
            return;
        }

        // Create fixtures
        $fixtures = [
            [
                'home_team_id' => $azamTeam->id,
                'away_team_id' => $simbaTeam->id,
                'match_date' => now()->addDays(5),
                'stadium' => 'Azam Complex Stadium',
                'competition_type' => 'Tanzania Premier League',
                'match_type' => 'league',
                'team_category' => 'senior',
                'match_preview' => 'Upcoming fixture between Azam FC and Simba SC',
                'status' => 'scheduled',
                'is_featured' => true,
            ],
            [
                'home_team_id' => $yangaTeam->id,
                'away_team_id' => $azamTeam->id,
                'match_date' => now()->addDays(12),
                'stadium' => 'Benjamin Mkapa Stadium',
                'competition_type' => 'Tanzania Premier League',
                'match_type' => 'league',
                'team_category' => 'senior',
                'match_preview' => 'Upcoming fixture between Young Africans SC and Azam FC',
                'status' => 'scheduled',
                'is_featured' => true,
            ],
            [
                'home_team_id' => $kageraTeam ? $kageraTeam->id : $azamTeam->id,
                'away_team_id' => $coastalTeam ? $coastalTeam->id : $simbaTeam->id,
                'match_date' => now()->addDays(8),
                'stadium' => 'Kaitaba Stadium',
                'competition_type' => 'Tanzania Premier League',
                'match_type' => 'league',
                'team_category' => 'senior',
                'match_preview' => 'Upcoming fixture in the Tanzania Premier League',
                'status' => 'scheduled',
                'is_featured' => false,
            ],
            [
                'home_team_id' => $azamTeam->id,
                'away_team_id' => $yangaTeam->id,
                'match_date' => now()->subDays(10),
                'stadium' => 'Azam Complex Stadium',
                'competition_type' => 'Tanzania Premier League',
                'match_type' => 'league',
                'team_category' => 'senior',
                'match_preview' => 'Past fixture between Azam FC and Young Africans SC',
                'status' => 'completed',
                'home_score' => 2,
                'away_score' => 1,
                'match_report' => 'Azam FC secured a 2-1 victory against Young Africans SC in an exciting match.',
                'attendance' => 15000,
                'referee' => 'John Doe',
                'is_featured' => true,
            ],
            [
                'home_team_id' => $simbaTeam->id,
                'away_team_id' => $azamTeam->id,
                'match_date' => now()->subDays(20),
                'stadium' => 'Benjamin Mkapa Stadium',
                'competition_type' => 'Tanzania Premier League',
                'match_type' => 'league',
                'team_category' => 'senior',
                'match_preview' => 'Past fixture between Simba SC and Azam FC',
                'status' => 'completed',
                'home_score' => 1,
                'away_score' => 1,
                'match_report' => 'The match between Simba SC and Azam FC ended in a 1-1 draw.',
                'attendance' => 18000,
                'referee' => 'Jane Smith',
                'is_featured' => true,
            ],
            [
                'home_team_id' => $coastalTeam ? $coastalTeam->id : $yangaTeam->id,
                'away_team_id' => $kageraTeam ? $kageraTeam->id : $simbaTeam->id,
                'match_date' => now()->subDays(15),
                'stadium' => 'Mkwakwani Stadium',
                'competition_type' => 'Tanzania Premier League',
                'match_type' => 'league',
                'team_category' => 'senior',
                'match_preview' => 'Past fixture in the Tanzania Premier League',
                'status' => 'completed',
                'home_score' => 0,
                'away_score' => 2,
                'match_report' => 'The away team secured a 2-0 victory.',
                'attendance' => 12000,
                'referee' => 'Robert Johnson',
                'is_featured' => false,
            ],
        ];

        foreach ($fixtures as $fixture) {
            if (!Fixture::where([
                'home_team_id' => $fixture['home_team_id'],
                'away_team_id' => $fixture['away_team_id'],
                'match_date' => $fixture['match_date']
            ])->exists()) {
                Fixture::create($fixture);
            }
        }
    }
}
