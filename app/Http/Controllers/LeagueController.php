<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    /**
     * Get league standings for frontend display
     */
    public function getStandings(Request $request)
    {
        $leagueName = $request->get('league', 'Tanzania Premier League');
        $season = $request->get('season', date('Y'));
        
        $standings = League::getCurrentStandings($leagueName, $season);
        
        return response()->json([
            'success' => true,
            'data' => $standings,
            'league' => $leagueName,
            'season' => $season
        ]);
    }
    
    /**
     * Get available seasons
     */
    public function getSeasons(Request $request)
    {
        $leagueName = $request->get('league', 'Tanzania Premier League');
        
        $seasons = League::where('name', $leagueName)
            ->distinct()
            ->pluck('season')
            ->sort()
            ->values();
            
        return response()->json([
            'success' => true,
            'data' => $seasons
        ]);
    }
}
