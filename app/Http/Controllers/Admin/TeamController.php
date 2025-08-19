<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::orderBy('name')->paginate(15);
        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams',
            'short_name' => 'nullable|string|max:10',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'home_stadium' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'social_media' => 'nullable|array',
            'primary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('teams/logos', 'public');
        }

        Team::create($validated);

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        // Get recent fixtures (last 10)
        $recentFixtures = $team->allFixtures()
            ->with(['homeTeam', 'awayTeam'])
            ->orderBy('match_date', 'desc')
            ->limit(10)
            ->get();

        // Calculate team statistics
        $completedFixtures = $team->allFixtures()
            ->where('status', 'completed')
            ->whereNotNull('home_score')
            ->whereNotNull('away_score')
            ->get();

        $totalFixtures = $completedFixtures->count();
        $wins = 0;
        $draws = 0;
        $losses = 0;

        foreach ($completedFixtures as $fixture) {
            if ($fixture->home_team_id == $team->id) {
                // Team is home
                if ($fixture->home_score > $fixture->away_score) {
                    $wins++;
                } elseif ($fixture->home_score == $fixture->away_score) {
                    $draws++;
                } else {
                    $losses++;
                }
            } else {
                // Team is away
                if ($fixture->away_score > $fixture->home_score) {
                    $wins++;
                } elseif ($fixture->away_score == $fixture->home_score) {
                    $draws++;
                } else {
                    $losses++;
                }
            }
        }

        return view('admin.teams.show', compact(
            'team', 
            'recentFixtures', 
            'totalFixtures', 
            'wins', 
            'draws', 
            'losses'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,' . $team->id,
            'short_name' => 'nullable|string|max:10',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'home_stadium' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'social_media' => 'nullable|array',
            'primary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($team->logo && Storage::disk('public')->exists($team->logo)) {
                Storage::disk('public')->delete($team->logo);
            }
            $validated['logo'] = $request->file('logo')->store('teams/logos', 'public');
        }

        $team->update($validated);

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        // Check if team has fixtures
        if ($team->allFixtures()->count() > 0) {
            return redirect()->route('admin.teams.index')
                ->with('error', 'Cannot delete team with existing fixtures.');
        }

        // Delete logo if exists
        if ($team->logo && Storage::disk('public')->exists($team->logo)) {
            Storage::disk('public')->delete($team->logo);
        }

        $team->delete();

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team deleted successfully.');
    }
}
