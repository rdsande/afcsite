<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leagues = League::with('team')
            ->active()
            ->currentSeason()
            ->standings()
            ->get();
            
        return view('admin.leagues.index', compact('leagues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::all();
        return view('admin.leagues.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'season' => 'required|string|max:255',
            'team_id' => 'required|exists:teams,id',
            'matches_played' => 'required|integer|min:0',
            'wins' => 'required|integer|min:0',
            'draws' => 'required|integer|min:0',
            'losses' => 'required|integer|min:0',
            'goals_for' => 'required|integer|min:0',
            'goals_against' => 'required|integer|min:0',
        ]);

        $league = League::create($request->all());
        $league->calculateGoalDifference();
        $league->calculatePoints();
        $league->save();
        
        // Update positions for all teams in this league and season
        League::updatePositions($request->name, $request->season);

        return redirect()->route('admin.leagues.index')
            ->with('success', 'League entry created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(League $league)
    {
        return view('admin.leagues.show', compact('league'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(League $league)
    {
        $teams = Team::all();
        return view('admin.leagues.edit', compact('league', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, League $league)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'season' => 'required|string|max:255',
            'team_id' => 'required|exists:teams,id',
            'matches_played' => 'required|integer|min:0',
            'wins' => 'required|integer|min:0',
            'draws' => 'required|integer|min:0',
            'losses' => 'required|integer|min:0',
            'goals_for' => 'required|integer|min:0',
            'goals_against' => 'required|integer|min:0',
        ]);

        $league->update($request->all());
        $league->calculateGoalDifference();
        $league->calculatePoints();
        $league->save();
        
        // Update positions for all teams in this league and season
        League::updatePositions($request->name, $request->season);

        return redirect()->route('admin.leagues.index')
            ->with('success', 'League entry updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(League $league)
    {
        $leagueName = $league->name;
        $season = $league->season;
        
        $league->delete();
        
        // Update positions for remaining teams in this league and season
        League::updatePositions($leagueName, $season);

        return redirect()->route('admin.leagues.index')
            ->with('success', 'League entry deleted successfully.');
    }
    
    /**
     * Get current standings for API
     */
    public function getStandings(Request $request)
    {
        $leagueName = $request->get('league', 'Tanzania Premier League');
        $season = $request->get('season', date('Y'));
        
        $standings = League::getCurrentStandings($leagueName, $season);
        
        return response()->json($standings);
    }
}
