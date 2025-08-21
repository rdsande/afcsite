<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fan;
use App\Models\PointTransaction;
use App\Models\FanMessage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class FanAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of fans with search and filters
     */
    public function index(Request $request)
    {
        $query = Fan::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by region
        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Filter by registration date
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort by points or registration date
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $fans = $query->paginate(20)->appends($request->query());

        // Get statistics
        $stats = [
            'total_fans' => Fan::count(),
            'new_this_month' => Fan::whereMonth('created_at', Carbon::now()->month)->count(),
            'active_fans' => Fan::where('last_login', '>=', Carbon::now()->subDays(30))->count(),
            'total_points_distributed' => PointTransaction::sum('points'),
        ];

        // Get filter options
        $regions = Fan::distinct()->pluck('region')->filter()->sort();

        return view('admin.fans.index', compact('fans', 'stats', 'regions'));
    }

    /**
     * Display the specified fan with detailed information
     */
    public function show(Fan $fan)
    {
        // Load relationships
        $fan->load(['pointTransactions' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }]);

        // Get fan statistics
        $stats = [
            'total_points' => $fan->points,
            'total_messages' => FanMessage::where('fan_id', $fan->id)->count(),
            'pending_messages' => FanMessage::where('fan_id', $fan->id)->where('status', 'open')->count(),

            'login_points' => $fan->getPointsByType('login'),
            'team_win_points' => $fan->getPointsByType('team_win'),
        ];

        // Get recent activity
        $recentTransactions = $fan->getRecentTransactions(10);
        $recentMessages = FanMessage::where('fan_id', $fan->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.fans.show', compact('fan', 'stats', 'recentTransactions', 'recentMessages'));
    }

    /**
     * Show the form for editing the specified fan
     */
    public function edit(Fan $fan)
    {
        return view('admin.fans.edit', compact('fan'));
    }

    /**
     * Update the specified fan in storage
     */
    public function update(Request $request, Fan $fan)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:fans,phone,' . $fan->id,
            'email' => 'nullable|email|unique:fans,email,' . $fan->id,
            'gender' => 'required|in:male,female,other',
            'region' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'points' => 'required|integer|min:0',
        ]);

        $oldPoints = $fan->points;
        $data = $request->all();
        
        $fan->update($data);

        // If points were manually adjusted, create a transaction record
        if ($oldPoints != $request->points) {
            $pointDifference = $request->points - $oldPoints;
            $fan->pointTransactions()->create([
                'points' => $pointDifference,
                'type' => 'admin_adjustment',
                'description' => 'Manual points adjustment by admin',
                'metadata' => ['admin_id' => auth()->id()]
            ]);
        }

        return redirect()->route('admin.fans.show', $fan)
            ->with('success', 'Fan information updated successfully.');
    }

    /**
     * Add points to a fan
     */
    public function addPoints(Request $request, Fan $fan)
    {
        $request->validate([
            'points' => 'required|integer|min:1|max:1000',
            'description' => 'required|string|max:255'
        ]);

        $fan->addPoints(
            $request->points,
            'admin_bonus',
            $request->description,
            ['admin_id' => auth()->id()]
        );

        return redirect()->route('admin.fans.show', $fan)
            ->with('success', "Added {$request->points} points to {$fan->full_name}.");
    }


}
