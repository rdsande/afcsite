<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Player;
use App\Models\MatchEvent;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FixtureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,editor');
    }

    /**
     * Display a listing of fixtures.
     */
    public function index(Request $request)
    {
        $query = Fixture::with(['tournament', 'homeTeam', 'awayTeam', 'matchEvents']);
        
        // Filter by tournament
        if ($request->filled('tournament_id')) {
            $query->where('tournament_id', $request->tournament_id);
        }
        
        // Filter by team category
        if ($request->filled('team_category')) {
            $query->where('team_category', $request->team_category);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $fixtures = $query->orderBy('match_date', 'desc')->paginate(15);
        $tournaments = Tournament::active()->get();
        
        return view('admin.fixtures.index', compact('fixtures', 'tournaments'));
    }

    /**
     * Show the form for creating a new fixture.
     */
    public function create()
    {
        $tournaments = Tournament::active()->get();
        $teams = Team::where('is_active', true)->orderBy('name')->get();
        return view('admin.fixtures.create', compact('tournaments', 'teams'));
    }

    /**
     * Store a newly created fixture in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'tournament_id' => 'required|exists:tournaments,id',
            'match_date' => 'required|date',
            'match_time' => 'required|date_format:H:i',
            'stadium' => 'required|string|max:255',
            'team_category' => 'required|in:senior,u20,u17,u15,u13',
            'match_type' => 'required|in:league,cup,friendly',
            'competition_type' => 'required|string|max:255',
            'is_home' => 'required|boolean',
            'match_preview' => 'nullable|string',
            'broadcast_link' => 'nullable|url',
            'is_featured' => 'boolean',
        ]);

        // Combine date and time
        $matchDateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $request->match_date . ' ' . $request->match_time
        );

        Fixture::create([
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'tournament_id' => $request->tournament_id,
            'match_date' => $matchDateTime,
            'stadium' => $request->stadium,
            'team_category' => $request->team_category,
            'match_type' => $request->match_type,
            'competition_type' => $request->competition_type,
            'is_home' => $request->boolean('is_home'),
            'match_preview' => $request->match_preview,
            'broadcast_link' => $request->broadcast_link,
            'is_featured' => $request->boolean('is_featured'),
            'status' => 'scheduled',
        ]);

        return redirect()->route('admin.fixtures.index')
            ->with('success', 'Fixture created successfully.');
    }

    /**
     * Display the specified fixture.
     */
    public function show(Fixture $fixture)
    {
        return view('admin.fixtures.show', compact('fixture'));
    }

    /**
     * Show the form for editing the specified fixture.
     */
    public function edit(Fixture $fixture)
    {
        $tournaments = Tournament::active()->get();
        $teams = Team::where('is_active', true)->orderBy('name')->get();
        $players = Player::where('team_category', $fixture->team_category)->get();
        $matchEvents = $fixture->matchEvents()->ordered()->get();
        
        return view('admin.fixtures.edit', compact('fixture', 'tournaments', 'teams', 'players', 'matchEvents'));
    }

    /**
     * Update the specified fixture in storage.
     */
    public function update(Request $request, Fixture $fixture)
    {
        $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'tournament_id' => 'required|exists:tournaments,id',
            'match_date' => 'required|date',
            'match_time' => 'required|date_format:H:i',
            'stadium' => 'required|string|max:255',
            'team_category' => 'required|in:senior,u20,u17,u15,u13',
            'match_type' => 'required|in:league,cup,friendly',
            'competition_type' => 'required|string|max:255',
            'is_home' => 'required|boolean',
            'match_preview' => 'nullable|string',
            'broadcast_link' => 'nullable|url',
            'is_featured' => 'boolean',
            'status' => 'required|in:scheduled,live,postponed,cancelled,completed',
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'match_report' => 'nullable|string',
            'attendance' => 'nullable|integer|min:0',
            'referee' => 'nullable|string|max:255',
        ]);

        // Combine date and time
        $matchDateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $request->match_date . ' ' . $request->match_time
        );

        $fixture->update([
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'tournament_id' => $request->tournament_id,
            'match_date' => $matchDateTime,
            'stadium' => $request->stadium,
            'team_category' => $request->team_category,
            'match_type' => $request->match_type,
            'competition_type' => $request->competition_type,
            'is_home' => $request->boolean('is_home'),
            'match_preview' => $request->match_preview,
            'broadcast_link' => $request->broadcast_link,
            'is_featured' => $request->boolean('is_featured'),
            'status' => $request->status,
            'home_score' => $request->home_score,
            'away_score' => $request->away_score,
            'match_report' => $request->match_report,
            'attendance' => $request->attendance,
            'referee' => $request->referee,
        ]);

        return redirect()->route('admin.fixtures.index')
            ->with('success', 'Fixture updated successfully.');
    }

    /**
     * Remove the specified fixture from storage.
     */
    public function destroy(Fixture $fixture)
    {
        $fixture->delete();

        return redirect()->route('admin.fixtures.index')
            ->with('success', 'Fixture deleted successfully.');
    }

    /**
     * Update fixture status.
     */
    public function updateStatus(Request $request, Fixture $fixture)
    {
        $request->validate([
            'status' => 'required|in:scheduled,live,postponed,cancelled,completed',
        ]);

        $fixture->update(['status' => $request->status]);

        return redirect()->route('admin.fixtures.index')
            ->with('success', 'Fixture status updated successfully.');
    }

    /**
     * Add match event (goal, card, live update).
     */
    public function addEvent(Request $request, Fixture $fixture)
    {
        $request->validate([
            'event_type' => 'required|in:goal,yellow_card,red_card,substitution,live_update',
            'minute' => 'required|integer|min:0|max:120',
            'player_id' => 'nullable|exists:players,id',
            'team' => 'required|in:home,away',
            'description' => 'nullable|string|max:500',
        ]);

        MatchEvent::create([
            'fixture_id' => $fixture->id,
            'event_type' => $request->event_type,
            'minute' => $request->minute,
            'player_id' => $request->player_id,
            'team' => $request->team,
            'description' => $request->description,
            'event_time' => now(),
            'is_live_update' => $request->event_type === 'live_update',
        ]);

        return redirect()->back()->with('success', 'Match event added successfully.');
    }

    /**
     * Remove match event.
     */
    public function removeEvent(MatchEvent $event)
    {
        $event->delete();
        return redirect()->back()->with('success', 'Match event removed successfully.');
    }

    /**
     * Update match result via AJAX.
     */
    public function updateResult(Request $request, Fixture $fixture)
    {
        $request->validate([
            'home_score' => 'required|integer|min:0',
            'away_score' => 'required|integer|min:0',
        ]);

        $fixture->update([
            'home_score' => $request->home_score,
            'away_score' => $request->away_score,
            'status' => 'completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Match result updated successfully!'
        ]);
    }

    /**
     * Get upcoming fixtures.
     */
    public function upcoming()
    {
        $fixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->where('match_date', '>', now())
            ->where('status', 'scheduled')
            ->orderBy('match_date', 'asc')
            ->paginate(10);

        return view('admin.fixtures.upcoming', compact('fixtures'));
    }

    /**
     * Get past fixtures.
     */
    public function past()
    {
        $fixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->where('match_date', '<', now())
            ->orWhere('status', 'completed')
            ->orderBy('match_date', 'desc')
            ->paginate(10);

        return view('admin.fixtures.past', compact('fixtures'));
    }

    /**
     * Convert fixture to match result.
     */
    public function convertToMatch(Fixture $fixture)
    {
        // Check if fixture is eligible for conversion
        if ($fixture->status !== 'completed' && $fixture->match_date > now()) {
            return redirect()->route('fixtures.index')
                ->with('error', 'Only completed fixtures can be converted to match results.');
        }

        return redirect()->route('matches.create', ['fixture_id' => $fixture->id])
            ->with('info', 'Creating match result from fixture.');
    }
}