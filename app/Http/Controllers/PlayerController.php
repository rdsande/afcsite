<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PlayerController extends Controller
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
     * Display a listing of the players.
     */
    public function index(Request $request)
    {
        $query = Player::query();

        // Filter by team
        if ($request->filled('team')) {
            $query->where('team', $request->team);
        }

        // Filter by position
        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('jersey_number', 'like', '%' . $request->search . '%')
                  ->orWhere('nationality', 'like', '%' . $request->search . '%');
            });
        }

        $players = $query->orderBy('jersey_number', 'asc')->paginate(15);

        return view('admin.players.index', compact('players'));
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
            'slug' => 'required|string|max:255|unique:players',
            'jersey_number' => 'required|integer|min:1|max:99|unique:players,jersey_number,NULL,id,team,' . $request->team,
            'position' => 'required|string|max:50',
            'team' => 'required|in:senior,u20,u17,u15,u13',
            'date_of_birth' => 'nullable|date|before:today',
            'nationality' => 'nullable|string|max:100',
            'height' => 'nullable|numeric|min:1.5|max:2.5',
            'biography' => 'nullable|string',
            'video_reel_link' => 'nullable|url|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,injured,suspended',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('players', $filename, 'public');
            $data['photo'] = $path;
        }

        Player::create($data);

        return redirect()->route('admin.players.index')
                        ->with('success', 'Player created successfully!');
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
            'slug' => 'required|string|max:255|unique:players,slug,' . $player->id,
            'jersey_number' => 'required|integer|min:1|max:99|unique:players,jersey_number,' . $player->id . ',id,team,' . $request->team,
            'position' => 'required|string|max:50',
            'team' => 'required|in:senior,u20,u17,u15,u13',
            'date_of_birth' => 'nullable|date|before:today',
            'nationality' => 'nullable|string|max:100',
            'height' => 'nullable|numeric|min:1.5|max:2.5',
            'biography' => 'nullable|string',
            'video_reel_link' => 'nullable|url|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,injured,suspended',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($player->photo) {
                Storage::disk('public')->delete($player->photo);
            }

            $image = $request->file('photo');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('players', $filename, 'public');
            $data['photo'] = $path;
        }

        $player->update($data);

        return redirect()->route('admin.players.index')
                        ->with('success', 'Player updated successfully!');
    }

    /**
     * Remove the specified player from storage.
     */
    public function destroy(Player $player)
    {
        // Delete photo if exists
        if ($player->photo) {
            Storage::disk('public')->delete($player->photo);
        }

        $player->delete();

        return redirect()->route('admin.players.index')
                        ->with('success', 'Player deleted successfully!');
    }
}