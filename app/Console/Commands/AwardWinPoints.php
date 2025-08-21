<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Fan;
use App\Models\Fixture;

class AwardWinPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fans:award-win-points {fixture_id : The ID of the fixture where AZAM FC won}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Award 5 points to all fans when AZAM FC wins a match';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fixtureId = $this->argument('fixture_id');
        
        $fixture = Fixture::find($fixtureId);
        
        if (!$fixture) {
            $this->error("Fixture with ID {$fixtureId} not found.");
            return 1;
        }
        
        // Check if AZAM FC won (either as home or away team)
        $azamWon = false;
        $azamTeam = null;
        
        if (strtolower($fixture->home_team) === 'azam fc' && $fixture->home_score > $fixture->away_score) {
            $azamWon = true;
            $azamTeam = 'home';
        } elseif (strtolower($fixture->away_team) === 'azam fc' && $fixture->away_score > $fixture->home_score) {
            $azamWon = true;
            $azamTeam = 'away';
        }
        
        if (!$azamWon) {
            $this->info('AZAM FC did not win this match. No points awarded.');
            return 0;
        }
        
        // Award points to all fans
        $fans = Fan::all();
        $pointsAwarded = 5;
        $fanCount = 0;
        
        foreach ($fans as $fan) {
            $fan->addPoints(
                $pointsAwarded, 
                'win', 
                "AZAM FC victory: {$fixture->home_team} vs {$fixture->away_team}",
                ['fixture_id' => $fixture->id, 'match_date' => $fixture->date]
            );
            $fanCount++;
        }
        
        $this->info("AZAM FC won! Awarded {$pointsAwarded} points to {$fanCount} fans.");
        $this->info("Match: {$fixture->home_team} {$fixture->home_score} - {$fixture->away_score} {$fixture->away_team}");
        
        return 0;
    }
}
