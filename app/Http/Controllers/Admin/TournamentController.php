<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tournaments = Tournament::with('fixtures')
            ->orderBy('is_active', 'desc')
            ->orderBy('start_date', 'desc')
            ->paginate(15);

        return view('admin.tournaments.index', compact('tournaments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tournaments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'type' => 'required|in:league,cup,friendly',
            'format' => 'required|in:round_robin,knockout,group_stage',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'season' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'settings' => 'nullable|json'
        ]);

        $data = $request->except(['logo']);
        
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('tournaments', 'public');
            $data['logo'] = $logoPath;
        }

        if ($request->has('settings') && $request->settings) {
            $data['settings'] = json_decode($request->settings, true);
        }

        Tournament::create($data);

        return redirect()->route('admin.tournaments.index')
            ->with('success', 'Tournament created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        $tournament->load(['fixtures' => function($query) {
            $query->orderBy('match_date', 'desc');
        }]);

        return view('admin.tournaments.show', compact('tournament'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament)
    {
        return view('admin.tournaments.edit', compact('tournament'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tournament $tournament)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'type' => 'required|in:league,cup,friendly',
            'format' => 'required|in:round_robin,knockout,group_stage',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'season' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'settings' => 'nullable|json'
        ]);

        $data = $request->except(['logo']);
        
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($tournament->logo) {
                Storage::disk('public')->delete($tournament->logo);
            }
            
            $logoPath = $request->file('logo')->store('tournaments', 'public');
            $data['logo'] = $logoPath;
        }

        if ($request->has('settings') && $request->settings) {
            $data['settings'] = json_decode($request->settings, true);
        }

        $tournament->update($data);

        return redirect()->route('admin.tournaments.index')
            ->with('success', 'Tournament updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament)
    {
        // Delete logo if exists
        if ($tournament->logo) {
            Storage::disk('public')->delete($tournament->logo);
        }

        $tournament->delete();

        return redirect()->route('admin.tournaments.index')
            ->with('success', 'Tournament deleted successfully.');
    }

    /**
     * Toggle tournament active status
     */
    public function toggleStatus(Tournament $tournament)
    {
        $tournament->update(['is_active' => !$tournament->is_active]);
        
        $status = $tournament->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Tournament {$status} successfully.");
    }
}
