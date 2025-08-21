<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FixtureApiController extends Controller
{
    /**
     * Get all fixtures
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 20);
        $page = $request->get('page', 1);
        $status = $request->get('status');
        $tournament = $request->get('tournament');

        $query = Fixture::with(['tournament', 'homeTeam', 'awayTeam']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($tournament) {
            $query->whereHas('tournament', function ($q) use ($tournament) {
                $q->where('slug', $tournament);
            });
        }

        $fixtures = $query->orderBy('match_date', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data' => $fixtures->items(),
            'pagination' => [
                'current_page' => $fixtures->currentPage(),
                'last_page' => $fixtures->lastPage(),
                'per_page' => $fixtures->perPage(),
                'total' => $fixtures->total(),
            ]
        ]);
    }

    /**
     * Get upcoming fixtures
     */
    public function upcoming(): JsonResponse
    {
        $upcomingFixtures = Fixture::with(['tournament', 'homeTeam', 'awayTeam'])
            ->where('match_date', '>', now())
            ->where('status', 'scheduled')
            ->orderBy('match_date', 'asc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $upcomingFixtures
        ]);
    }

    /**
     * Get recent results
     */
    public function results(): JsonResponse
    {
        $results = Fixture::with(['tournament', 'homeTeam', 'awayTeam'])
            ->where('match_date', '<', now())
            ->where('status', 'completed')
            ->orderBy('match_date', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }

    /**
     * Get a specific fixture
     */
    public function show(Fixture $fixture): JsonResponse
    {
        $fixture->load(['tournament', 'homeTeam', 'awayTeam', 'events']);

        return response()->json([
            'success' => true,
            'data' => $fixture
        ]);
    }
}
