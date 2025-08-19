<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MatchResult;
use App\Models\Fixture;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,editor');
    }

    /**
     * Display a listing of matches.
     */
    public function index()
    {
        $matches = MatchResult::orderBy('match_date', 'desc')
            ->paginate(10);
        return view('admin.matches.index', compact('matches'));
    }

    /**
     * Show the form for creating a new match.
     */
    public function create(Request $request)
    {
        $fixture = null;
        if ($request->has('fixture_id')) {
            $fixture = Fixture::find($request->fixture_id);
        }
        
        return view('admin.matches.create', compact('fixture'));
    }

    /**
     * Store a newly created match in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'opponent' => 'required|string|max:255',
            'match_date' => 'required|date|before_or_equal:now',
            'match_time' => 'required|date_format:H:i',
            'venue' => 'required|string|max:255',
            'is_home' => 'required|boolean',
            'competition' => 'required|string|max:255',
            'azam_score' => 'required|integer|min:0',
            'opponent_score' => 'required|integer|min:0',
            'attendance' => 'nullable|integer|min:0',
            'match_report' => 'nullable|string',
            'fixture_id' => 'nullable|exists:fixtures,id',
        ]);

        // Combine date and time
        $matchDateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $request->match_date . ' ' . $request->match_time
        );

        // Determine result
        $result = 'draw';
        if ($request->azam_score > $request->opponent_score) {
            $result = 'win';
        } elseif ($request->azam_score < $request->opponent_score) {
            $result = 'loss';
        }

        $match = MatchResult::create([
            'opponent' => $request->opponent,
            'match_date' => $matchDateTime,
            'venue' => $request->venue,
            'is_home' => $request->boolean('is_home'),
            'competition' => $request->competition,
            'azam_score' => $request->azam_score,
            'opponent_score' => $request->opponent_score,
            'result' => $result,
            'attendance' => $request->attendance,
            'match_report' => $request->match_report,
            'fixture_id' => $request->fixture_id,
        ]);

        // Update related fixture status if exists
        if ($request->fixture_id) {
            $fixture = Fixture::find($request->fixture_id);
            if ($fixture) {
                $fixture->update(['status' => 'completed']);
            }
        }

        return redirect()->route('matches.index')
            ->with('success', 'Match result created successfully.');
    }

    /**
     * Display the specified match.
     */
    public function show(MatchResult $match)
    {
        return view('admin.matches.show', compact('match'));
    }

    /**
     * Show the form for editing the specified match.
     */
    public function edit(MatchResult $match)
    {
        return view('admin.matches.edit', compact('match'));
    }

    /**
     * Update the specified match in storage.
     */
    public function update(Request $request, MatchResult $match)
    {
        $request->validate([
            'opponent' => 'required|string|max:255',
            'match_date' => 'required|date|before_or_equal:now',
            'match_time' => 'required|date_format:H:i',
            'venue' => 'required|string|max:255',
            'is_home' => 'required|boolean',
            'competition' => 'required|string|max:255',
            'azam_score' => 'required|integer|min:0',
            'opponent_score' => 'required|integer|min:0',
            'attendance' => 'nullable|integer|min:0',
            'match_report' => 'nullable|string',
        ]);

        // Combine date and time
        $matchDateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $request->match_date . ' ' . $request->match_time
        );

        // Determine result
        $result = 'draw';
        if ($request->azam_score > $request->opponent_score) {
            $result = 'win';
        } elseif ($request->azam_score < $request->opponent_score) {
            $result = 'loss';
        }

        $match->update([
            'opponent' => $request->opponent,
            'match_date' => $matchDateTime,
            'venue' => $request->venue,
            'is_home' => $request->boolean('is_home'),
            'competition' => $request->competition,
            'azam_score' => $request->azam_score,
            'opponent_score' => $request->opponent_score,
            'result' => $result,
            'attendance' => $request->attendance,
            'match_report' => $request->match_report,
        ]);

        return redirect()->route('matches.index')
            ->with('success', 'Match result updated successfully.');
    }

    /**
     * Remove the specified match from storage.
     */
    public function destroy(MatchResult $match)
    {
        // Reset related fixture status if exists
        if ($match->fixture_id) {
            $fixture = Fixture::find($match->fixture_id);
            if ($fixture) {
                $fixture->update(['status' => 'scheduled']);
            }
        }

        $match->delete();

        return redirect()->route('matches.index')
            ->with('success', 'Match result deleted successfully.');
    }

    /**
     * Get recent matches.
     */
    public function recent()
    {
        $matches = MatchResult::orderBy('match_date', 'desc')
            ->limit(10)
            ->get();

        return view('admin.matches.recent', compact('matches'));
    }

    /**
     * Get matches by result type.
     */
    public function byResult($result)
    {
        if (!in_array($result, ['win', 'loss', 'draw'])) {
            abort(404);
        }

        $matches = MatchResult::where('result', $result)
            ->orderBy('match_date', 'desc')
            ->paginate(10);

        return view('admin.matches.by-result', compact('matches', 'result'));
    }

    /**
     * Get match statistics.
     */
    public function statistics()
    {
        $stats = [
            'total_matches' => MatchResult::count(),
            'wins' => MatchResult::where('result', 'win')->count(),
            'losses' => MatchResult::where('result', 'loss')->count(),
            'draws' => MatchResult::where('result', 'draw')->count(),
            'goals_scored' => MatchResult::sum('azam_score'),
            'goals_conceded' => MatchResult::sum('opponent_score'),
            'average_attendance' => MatchResult::whereNotNull('attendance')->avg('attendance'),
            'home_matches' => MatchResult::where('is_home', true)->count(),
            'away_matches' => MatchResult::where('is_home', false)->count(),
        ];

        // Calculate win percentage
        $stats['win_percentage'] = $stats['total_matches'] > 0 
            ? round(($stats['wins'] / $stats['total_matches']) * 100, 2) 
            : 0;

        // Calculate goal difference
        $stats['goal_difference'] = $stats['goals_scored'] - $stats['goals_conceded'];

        return view('admin.matches.statistics', compact('stats'));
    }
}