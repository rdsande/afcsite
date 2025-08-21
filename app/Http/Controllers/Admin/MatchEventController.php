<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MatchEvent;
use App\Models\Fixture;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MatchEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,editor');
    }

    /**
     * Display a listing of match events for a fixture.
     */
    public function index(Fixture $fixture)
    {
        $events = $fixture->matchEvents()->with('player')->ordered()->get();
        $players = Player::where('team_category', $fixture->team_category)->get();
        
        // Return JSON for AJAX requests
        if (request()->expectsJson()) {
            $eventsData = $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'type' => $event->event_type,
                    'minute' => $event->minute,
                    'team' => $event->team,
                    'player' => $event->player ? $event->player->name : null,
                    'description' => $event->description,
                    'icon' => $event->event_icon,
                    'display_name' => $event->event_display_name,
                    'formatted_minute' => $event->formatted_minute,
                ];
            });

            return response()->json([
                'success' => true,
                'events' => $eventsData,
                'fixture_status' => $fixture->status,
                'is_live' => $fixture->is_live,
            ]);
        }
        
        return view('admin.match-events.index', compact('fixture', 'events', 'players'));
    }

    /**
     * Store a newly created match event.
     */
    public function store(Request $request, Fixture $fixture)
    {
        $request->validate([
            'event_type' => 'required|in:goal,yellow_card,red_card,substitution,live_update,kick_off,half_time,full_time',
            'minute' => 'required|integer|min:0|max:120',
            'player_id' => 'nullable|exists:players,id',
            'team' => 'required|in:home,away',
            'description' => 'nullable|string|max:500',
            'metadata' => 'nullable|array',
        ]);

        $event = MatchEvent::create([
            'fixture_id' => $fixture->id,
            'event_type' => $request->event_type,
            'minute' => $request->minute,
            'player_id' => $request->player_id,
            'team' => $request->team,
            'description' => $request->description,
            'metadata' => $request->metadata ?? [],
            'event_time' => now(),
            'is_live_update' => in_array($request->event_type, ['live_update', 'kick_off', 'half_time', 'full_time']),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'event' => $event->load('player'),
                'message' => 'Match event added successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Match event added successfully.');
    }

    /**
     * Update the specified match event.
     */
    public function update(Request $request, MatchEvent $event)
    {
        $request->validate([
            'event_type' => 'required|in:goal,yellow_card,red_card,substitution,live_update,kick_off,half_time,full_time',
            'minute' => 'required|integer|min:0|max:120',
            'player_id' => 'nullable|exists:players,id',
            'team' => 'required|in:home,away',
            'description' => 'nullable|string|max:500',
            'metadata' => 'nullable|array',
        ]);

        $event->update([
            'event_type' => $request->event_type,
            'minute' => $request->minute,
            'player_id' => $request->player_id,
            'team' => $request->team,
            'description' => $request->description,
            'metadata' => $request->metadata ?? [],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'event' => $event->load('player'),
                'message' => 'Match event updated successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Match event updated successfully.');
    }

    /**
     * Remove the specified match event.
     */
    public function destroy(MatchEvent $event)
    {
        $event->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Match event deleted successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Match event deleted successfully.');
    }

    /**
     * Get live events for a fixture (AJAX).
     */
    public function getLiveEvents(Fixture $fixture): JsonResponse
    {
        $events = $fixture->matchEvents()
            ->with('player')
            ->ordered()
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'type' => $event->event_type,
                    'minute' => $event->minute,
                    'team' => $event->team,
                    'player' => $event->player ? $event->player->name : null,
                    'description' => $event->description,
                    'icon' => $event->event_icon,
                    'display_name' => $event->event_display_name,
                    'formatted_minute' => $event->formatted_minute,
                ];
            });

        return response()->json([
            'success' => true,
            'events' => $events,
            'fixture_status' => $fixture->status,
            'is_live' => $fixture->is_live,
        ]);
    }

    /**
     * Bulk add multiple events (for quick match setup).
     */
    public function bulkStore(Request $request, Fixture $fixture)
    {
        $request->validate([
            'events' => 'required|array|min:1',
            'events.*.event_type' => 'required|in:goal,yellow_card,red_card,substitution,live_update',
            'events.*.minute' => 'required|integer|min:0|max:120',
            'events.*.player_id' => 'nullable|exists:players,id',
            'events.*.team' => 'required|in:home,away',
            'events.*.description' => 'nullable|string|max:500',
        ]);

        $createdEvents = [];
        foreach ($request->events as $eventData) {
            $event = MatchEvent::create([
                'fixture_id' => $fixture->id,
                'event_type' => $eventData['event_type'],
                'minute' => $eventData['minute'],
                'player_id' => $eventData['player_id'] ?? null,
                'team' => $eventData['team'],
                'description' => $eventData['description'] ?? null,
                'event_time' => now(),
                'is_live_update' => $eventData['event_type'] === 'live_update',
            ]);
            $createdEvents[] = $event->load('player');
        }

        return response()->json([
            'success' => true,
            'events' => $createdEvents,
            'message' => count($createdEvents) . ' events added successfully.'
        ]);
    }
}
