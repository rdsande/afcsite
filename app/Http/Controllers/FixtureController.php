<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FixtureController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the fixtures.
     */
    public function index(Request $request)
    {
        $query = Fixture::with(['homeTeam', 'awayTeam']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by competition
        if ($request->filled('competition')) {
            $query->where('competition', $request->competition);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('match_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('match_date', '<=', $request->date_to);
        }

        // Filter by upcoming/completed
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'upcoming':
                    $query->where('match_date', '>', now())
                          ->where('status', 'scheduled');
                    break;
                case 'completed':
                    $query->where('status', 'completed');
                    break;
            }
        }

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('homeTeam', function($teamQuery) use ($request) {
                    $teamQuery->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('awayTeam', function($teamQuery) use ($request) {
                    $teamQuery->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhere('stadium', 'like', '%' . $request->search . '%')
                ->orWhere('competition_type', 'like', '%' . $request->search . '%');
            });
        }

        $fixtures = $query->orderBy('match_date', 'desc')->paginate(15);

        return view('admin.fixtures.index', compact('fixtures'));
    }

    /**
     * Show the form for creating a new fixture.
     */
    public function create()
    {
        return view('admin.fixtures.create');
    }

    /**
     * Store a newly created fixture in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'tournament_id' => 'nullable|exists:tournaments,id',
            'match_date' => 'required|date',
            'match_time' => 'required|date_format:H:i',
            'competition_type' => 'nullable|string|max:255',
            'stadium' => 'nullable|string|max:255',
            'match_preview' => 'nullable|string',
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'status' => 'required|in:scheduled,live,completed,postponed,cancelled',
            'is_featured' => 'boolean',
            'team_category' => 'required|in:senior,u20,u17,u15,u13',
            'match_type' => 'required|in:league,cup,friendly',
        ]);

        // Combine date and time
        $matchDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->match_date . ' ' . $request->match_time);

        $data = [
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'tournament_id' => $request->tournament_id,
            'match_date' => $matchDateTime,
            'stadium' => $request->stadium,
            'competition_type' => $request->competition_type,
            'match_preview' => $request->match_preview,
            'home_score' => $request->home_score,
            'away_score' => $request->away_score,
            'status' => $request->status,
            'is_featured' => $request->boolean('is_featured'),
            'team_category' => $request->team_category,
            'match_type' => $request->match_type,
        ];

        // Auto-set status to completed if both scores are provided
        if ($request->filled('home_score') && $request->filled('away_score') && $data['status'] === 'scheduled') {
            $data['status'] = 'completed';
        }

        Fixture::create($data);

        return redirect()->route('admin.fixtures.index')
                        ->with('success', 'Fixture created successfully!');
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
        return view('admin.fixtures.edit', compact('fixture'));
    }

    /**
     * Update the specified fixture in storage.
     */
    public function update(Request $request, Fixture $fixture)
    {
        $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'tournament_id' => 'nullable|exists:tournaments,id',
            'match_date' => 'required|date',
            'match_time' => 'required|date_format:H:i',
            'competition_type' => 'nullable|string|max:255',
            'stadium' => 'nullable|string|max:255',
            'match_preview' => 'nullable|string',
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'status' => 'required|in:scheduled,live,completed,postponed,cancelled',
            'is_featured' => 'boolean',
            'team_category' => 'required|in:senior,u20,u17,u15,u13',
            'match_type' => 'required|in:league,cup,friendly',
        ]);

        // Combine date and time
        $matchDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->match_date . ' ' . $request->match_time);

        $data = [
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'tournament_id' => $request->tournament_id,
            'match_date' => $matchDateTime,
            'stadium' => $request->stadium,
            'competition_type' => $request->competition_type,
            'match_preview' => $request->match_preview,
            'home_score' => $request->home_score,
            'away_score' => $request->away_score,
            'status' => $request->status,
            'is_featured' => $request->boolean('is_featured'),
            'team_category' => $request->team_category,
            'match_type' => $request->match_type,
        ];

        // Auto-set status to completed if both scores are provided
        if ($request->filled('home_score') && $request->filled('away_score') && $data['status'] === 'scheduled') {
            $data['status'] = 'completed';
        }

        $fixture->update($data);

        return redirect()->route('admin.fixtures.index')
                        ->with('success', 'Fixture updated successfully!');
    }

    /**
     * Remove the specified fixture from storage.
     */
    public function destroy(Fixture $fixture)
    {
        $fixture->delete();

        return redirect()->route('admin.fixtures.index')
                        ->with('success', 'Fixture deleted successfully!');
    }

    /**
     * Update match result via AJAX.
     */
    public function updateResult(Request $request, Fixture $fixture)
    {
        $request->validate([
            'home_score' => 'required|integer|min:0',
            'away_score' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $fixture->update([
            'home_score' => $request->home_score,
            'away_score' => $request->away_score,
            'notes' => $request->notes,
            'status' => 'completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Match result updated successfully!'
        ]);
    }
}