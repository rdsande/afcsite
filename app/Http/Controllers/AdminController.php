<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Player;
use App\Models\Fixture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
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
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        // Get statistics
        $newsCount = News::count();
        $playersCount = Player::count();
        $fixturesCount = Fixture::count();
        $upcomingFixtures = Fixture::where('match_date', '>', now())
                                  ->where('status', 'scheduled')
                                  ->count();

        // Get recent news (last 5)
        $recentNews = News::with('author')
                         ->orderBy('created_at', 'desc')
                         ->limit(5)
                         ->get();

        // Get upcoming fixtures (next 5)
        $upcomingFixturesList = Fixture::with(['homeTeam', 'awayTeam'])
                                      ->where('match_date', '>', now())
                                      ->where('status', 'scheduled')
                                      ->orderBy('match_date', 'asc')
                                      ->limit(5)
                                      ->get();

        return view('admin.dashboard', compact(
            'newsCount',
            'playersCount', 
            'fixturesCount',
            'upcomingFixtures',
            'recentNews',
            'upcomingFixturesList'
        ));
    }

    /**
     * Display a listing of users.
     */
    public function userIndex(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function userCreate()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,editor',
            'status' => 'required|in:active,inactive',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified user.
     */
    public function userShow(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function userEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function userUpdate(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ];

        // Only super admins can change role and status
        if (auth()->user()->role === 'super_admin' && auth()->user()->id !== $user->id) {
            $rules['role'] = 'required|in:admin,editor';
            $rules['status'] = 'required|in:active,inactive';
        }

        // Password is optional for updates
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Only super admins can update role and status
        if (auth()->user()->role === 'super_admin' && auth()->user()->id !== $user->id) {
            $data['role'] = $request->role;
            $data['status'] = $request->status;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User updated successfully!');
    }

    /**
     * Handle image uploads for TinyMCE editor
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/editor', $filename, 'public');
            
            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Remove the specified user.
     */
    public function userDestroy(User $user)
    {
        // Prevent deletion of super admin and self
        if ($user->role === 'super_admin' || auth()->user()->id === $user->id) {
            return redirect()->route('admin.users.index')
                            ->with('error', 'Cannot delete this user.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', 'User deleted successfully!');
    }
}