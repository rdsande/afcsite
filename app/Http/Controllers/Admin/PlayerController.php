<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlayerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,editor');
    }

    /**
     * Display a listing of players.
     */
    public function index(Request $request)
    {
        $query = Player::query();
        
        // Filter by team category if specified
        if ($request->has('team')) {
            if ($request->team === 'senior') {
                $query->where('team_category', 'senior');
            } elseif ($request->team === 'academy') {
                $query->whereIn('team_category', ['u13', 'u15', 'u17', 'u20']);
            }
        }
        
        $players = $query->orderBy('jersey_number', 'asc')->paginate(15);
        
        // Get counts for each team category
        $seniorCount = Player::where('team_category', 'senior')->count();
        $academyCount = Player::whereIn('team_category', ['u13', 'u15', 'u17', 'u20'])->count();
        $totalCount = Player::count();
        
        return view('admin.players.index', compact('players', 'seniorCount', 'academyCount', 'totalCount'));
    }

    /**
     * Show the form for creating a new player.
     */
    public function create()
    {
        return view('admin.players.create');
    }

    /**
     * Store a newly created player in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:players',
            'jersey_number' => 'nullable|integer|min:1|max:99|unique:players',
            'position' => 'required|in:Goalkeeper,Defender,Midfielder,Forward',
            'team' => 'required|in:senior,u20,u17,u15,u13',
            'date_of_birth' => 'nullable|date|before:today',
            'nationality' => 'nullable|string|max:100',
            'height' => 'nullable|numeric|min:1.5|max:2.5',

            'biography' => 'nullable|string',
            'video_reel_link' => 'nullable|string|max:10000',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_captain' => 'boolean',
            // Statistical fields
            'goals_inside_box' => 'nullable|integer|min:0',
            'goals_outside_box' => 'nullable|integer|min:0',
            'assists' => 'nullable|integer|min:0',
            'passes_completed' => 'nullable|integer|min:0',
            'passes_lost' => 'nullable|integer|min:0',
            'tackles_won' => 'nullable|integer|min:0',
            'tackles_lost' => 'nullable|integer|min:0',
            'interceptions' => 'nullable|integer|min:0',
            'clearances' => 'nullable|integer|min:0',
            'blocks' => 'nullable|integer|min:0',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'jersey_number' => $request->jersey_number,
            'position' => $request->position,
            'team_category' => $request->team,
            'date_of_birth' => $request->date_of_birth,
            'nationality' => $request->nationality,
            'height' => $request->height,

            'biography' => $request->biography,
            'video_reel_link' => $request->video_reel_link,
            'is_active' => $request->boolean('is_active', true),
            'is_captain' => $request->boolean('is_captain'),
            // Statistical fields
            'goals_inside_box' => $request->goals_inside_box ?? 0,
            'goals_outside_box' => $request->goals_outside_box ?? 0,
            'assists' => $request->assists ?? 0,
            'passes_completed' => $request->passes_completed ?? 0,
            'passes_lost' => $request->passes_lost ?? 0,
            'tackles_won' => $request->tackles_won ?? 0,
            'tackles_lost' => $request->tackles_lost ?? 0,
            'interceptions' => $request->interceptions ?? 0,
            'clearances' => $request->clearances ?? 0,
            'blocks' => $request->blocks ?? 0,
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('players', 'public');
            $data['profile_image'] = $photoPath;
        }

        // Ensure only one captain at a time
        if ($data['is_captain']) {
            Player::where('is_captain', true)->update(['is_captain' => false]);
        }

        Player::create($data);

        return redirect()->route('admin.players.index')
            ->with('success', 'Player created successfully.');
    }

    /**
     * Display the specified player.
     */
    public function show(Player $player)
    {
        return view('admin.players.show', compact('player'));
    }

    /**
     * Show the form for editing the specified player.
     */
    public function edit(Player $player)
    {
        return view('admin.players.edit', compact('player'));
    }

    /**
     * Update the specified player in storage.
     */
    public function update(Request $request, Player $player)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:players,slug,' . $player->id,
            'jersey_number' => 'nullable|integer|min:1|max:99|unique:players,jersey_number,' . $player->id,
            'position' => 'required|in:Goalkeeper,Defender,Midfielder,Forward',
            'team' => 'required|in:senior,u20,u17,u15,u13',
            'date_of_birth' => 'nullable|date|before:today',
            'nationality' => 'nullable|string|max:100',
            'height' => 'nullable|numeric|min:1.5|max:2.5',
            'weight' => 'nullable|numeric|min:50|max:150',
            'biography' => 'nullable|string',
            'video_reel_link' => 'nullable|string|max:10000',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_captain' => 'boolean',
            // Statistical fields
            'goals_inside_box' => 'nullable|integer|min:0',
            'goals_outside_box' => 'nullable|integer|min:0',
            'assists' => 'nullable|integer|min:0',
            'passes_completed' => 'nullable|integer|min:0',
            'passes_lost' => 'nullable|integer|min:0',
            'tackles_won' => 'nullable|integer|min:0',
            'tackles_lost' => 'nullable|integer|min:0',
            'interceptions' => 'nullable|integer|min:0',
            'clearances' => 'nullable|integer|min:0',
            'blocks' => 'nullable|integer|min:0',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'jersey_number' => $request->jersey_number,
            'position' => $request->position,
            'team_category' => $request->team,
            'date_of_birth' => $request->date_of_birth,
            'nationality' => $request->nationality,
            'height' => $request->height,
            'video_reel_link' => $request->video_reel_link,
            'biography' => $request->biography,
            'is_active' => $request->boolean('is_active', true),
            'is_captain' => $request->boolean('is_captain'),
            // Statistical fields
            'goals_inside_box' => $request->goals_inside_box ?? 0,
            'goals_outside_box' => $request->goals_outside_box ?? 0,
            'assists' => $request->assists ?? 0,
            'passes_completed' => $request->passes_completed ?? 0,
            'passes_lost' => $request->passes_lost ?? 0,
            'tackles_won' => $request->tackles_won ?? 0,
            'tackles_lost' => $request->tackles_lost ?? 0,
            'interceptions' => $request->interceptions ?? 0,
            'clearances' => $request->clearances ?? 0,
            'blocks' => $request->blocks ?? 0,
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($player->profile_image) {
                Storage::disk('public')->delete($player->profile_image);
            }
            $photoPath = $request->file('photo')->store('players', 'public');
            $data['profile_image'] = $photoPath;
        }

        // Ensure only one captain at a time
        if ($data['is_captain'] && !$player->is_captain) {
            Player::where('is_captain', true)->update(['is_captain' => false]);
        }

        $player->update($data);

        return redirect()->route('admin.players.index')
            ->with('success', 'Player updated successfully.');
    }

    /**
     * Remove the specified player from storage.
     */
    public function destroy(Player $player)
    {
        // Delete photo if exists
        if ($player->profile_image) {
            Storage::disk('public')->delete($player->profile_image);
        }

        $player->delete();

        return redirect()->route('admin.players.index')
            ->with('success', 'Player deleted successfully.');
    }

    /**
     * Toggle player active status.
     */
    public function toggleStatus(Player $player)
    {
        $player->is_active = !$player->is_active;
        $player->save();

        $status = $player->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.players.index')
            ->with('success', "Player {$status} successfully.");
    }

    /**
     * Set player as captain.
     */
    public function setCaptain(Player $player)
    {
        // Remove captain status from all players
        Player::where('is_captain', true)->update(['is_captain' => false]);
        
        // Set this player as captain
        $player->update(['is_captain' => true]);

        return redirect()->route('admin.players.index')
            ->with('success', 'Player set as captain successfully.');
    }
}