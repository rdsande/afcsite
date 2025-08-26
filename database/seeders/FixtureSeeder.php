<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fixture;
use App\Models\Team;
use Carbon\Carbon;

class FixtureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get teams for fixtures
        $teams = Team::all();
        
        if ($teams->count() < 2) {
            // Create some basic teams if none exist
            $azamfc = Team::create([
                'name' => 'Azam FC',
                'slug' => 'azam-fc',
                'logo' => 'teams/azam-fc.png',
                'founded' => '2004-01-01',
                'stadium' => 'Azam Complex',
                'description' => 'Azam Football Club'
            ]);
            
            $simba = Team::create([
                'name' => 'Simba SC',
                'slug' => 'simba-sc',
                'logo' => 'teams/simba-sc.png',
                'founded' => '1936-01-01',
                'stadium' => 'Benjamin Mkapa Stadium',
                'description' => 'Simba Sports Club'
            ]);
            
            $yanga = Team::create([
                'name' => 'Young Africans SC',
                'slug' => 'young-africans-sc',
                'logo' => 'teams/yanga-sc.png',
                'founded' => '1935-01-01',
                'stadium' => 'Benjamin Mkapa Stadium',
                'description' => 'Young Africans Sports Club'
            ]);
            
            $teams = collect([$azamfc, $simba, $yanga]);
        }
        
        $azamfc = $teams->where('name', 'Azam FC')->first() ?? $teams->first();
        $opponents = $teams->where('id', '!=', $azamfc->id);
        
        $simbaTeam = $teams->where('name', 'Simba SC')->first();
        $yangaTeam = $teams->where('name', 'Young Africans SC')->first();
        
        $fixtures = [
            [
                'home_team_id' => $azamfc->id,
                'away_team_id' => $simbaTeam ? $simbaTeam->id : $opponents->first()->id,
                'match_date' => Carbon::now()->addDays(7)->setTime(16, 0),
                'stadium' => 'Azam Complex',
                'competition_type' => 'NBC Premier League',
                'match_type' => 'league',
                'team_category' => 'senior',
                'match_preview' => 'Exciting match between two top teams.',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'home_team_id' => $yangaTeam ? $yangaTeam->id : $opponents->first()->id,
                'away_team_id' => $azamfc->id,
                'match_date' => Carbon::now()->addDays(14)->setTime(19, 0),
                'stadium' => 'Benjamin Mkapa Stadium',
                'competition_type' => 'NBC Premier League',
                'match_type' => 'league',
                'team_category' => 'senior',
                'match_preview' => 'Away fixture for Azam FC.',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'home_team_id' => $azamfc->id,
                'away_team_id' => $opponents->skip(1)->first() ? $opponents->skip(1)->first()->id : $opponents->first()->id,
                'match_date' => Carbon::now()->subDays(7)->setTime(16, 0),
                'stadium' => 'Azam Complex',
                'competition_type' => 'NBC Premier League',
                'match_type' => 'league',
                'team_category' => 'senior',
                'match_preview' => 'Previous match result.',
                'status' => 'completed',
                'home_score' => 2,
                'away_score' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        foreach ($fixtures as $fixture) {
            Fixture::create($fixture);
        }
    }
}
