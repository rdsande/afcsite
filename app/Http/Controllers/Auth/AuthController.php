<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\News;
use App\Models\Player;
use App\Models\Fixture;
use App\Models\MatchResult;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Check if user exists and is active
        $user = User::where('email', $credentials['email'])->first();
        
        if (!$user || !$user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Your account is inactive or does not exist.'],
            ]);
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Update last login
            Auth::user()->updateLastLogin();
            
            // Redirect based on role
            if (Auth::user()->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            }
            
            return redirect()->intended('/admin/content');
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    public function showRegistrationForm()
    {
        // Only allow super admins to access registration
        if (!Auth::check() || !Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access.');
        }
        
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Only allow super admins to register new users
        if (!Auth::check() || !Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,editor',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User created successfully.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        if (!$user->canManageContent()) {
            abort(403, 'Unauthorized access.');
        }

        // Get dashboard statistics
        $newsCount = News::count();
        $playersCount = Player::count();
        $fixturesCount = Fixture::upcoming()->count();
        $matchesCount = MatchResult::recent()->count();
        
        return view('admin.dashboard', compact(
            'newsCount',
            'playersCount', 
            'fixturesCount',
            'matchesCount'
        ));
    }
}
