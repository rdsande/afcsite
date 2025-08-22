<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PlayerApiController extends Controller
{
    /**
     * Get all active players
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 20);
        $page = $request->get('page', 1);
        $position = $request->get('position');
        $team = $request->get('team');

        $query = Player::active();

        if ($position) {
            $query->where('position', $position);
        }

        if ($team) {
            $query->where('team_category', $team);
        }

        $players = $query->orderBy('jersey_number')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data' => $players->items(),
            'pagination' => [
                'current_page' => $players->currentPage(),
                'last_page' => $players->lastPage(),
                'per_page' => $players->perPage(),
                'total' => $players->total(),
            ]
        ]);
    }

    /**
     * Get senior team players
     */
    public function senior(): JsonResponse
    {
        $players = Player::active()
            ->senior()
            ->orderBy('jersey_number')
            ->get()
            ->groupBy('position');

        return response()->json([
            'success' => true,
            'data' => $players
        ]);
    }

    /**
     * Get academy team players
     */
    public function academy(string $team): JsonResponse
    {
        $validTeams = ['u13', 'u15', 'u17', 'u20'];

        if (!in_array($team, $validTeams)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid team specified'
            ], 400);
        }

        $players = Player::active()
            ->where('team_category', $team)
            ->orderBy('jersey_number')
            ->get()
            ->groupBy('position');

        return response()->json([
            'success' => true,
            'data' => $players
        ]);
    }

    /**
     * Get a specific player
     */
    public function show(Player $player): JsonResponse
    {
        if (!$player->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Player not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $player
        ]);
    }
}
