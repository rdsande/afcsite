<?php

namespace App\Http\Controllers;

use App\Models\Fan;
use App\Models\Region;
use App\Models\District;
use App\Models\Fixture;
use App\Models\AdminNotice;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class FanController extends Controller
{
    public function showRegister()
    {
        $regions = Region::orderBy('name')->get();
        return view('fan.register', compact('regions'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'phone' => 'required|string|unique:fans,phone|max:20',
            'email' => 'nullable|email|unique:fans,email',
            'gender' => 'required|in:male,female,other',
            'region_id' => 'required|exists:regions,id',
            'district_id' => 'required|exists:districts,id',
            'ward' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $region = Region::find($request->region_id);
        $district = District::find($request->district_id);

        $fan = Fan::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'country' => 'Tanzania',
            'region' => $region->name,
            'district' => $district->name,
            'ward' => $request->ward,
            'street' => $request->street,
            'password' => Hash::make($request->password),
            'points' => 10, // Welcome bonus
        ]);

        Auth::guard('fan')->login($fan);
        
        return redirect()->route('fan.dashboard')->with('success', 'Registration successful! Welcome to AZAM FC!');
    }

    public function showLogin()
    {
        return view('fan.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('fan')->attempt($credentials)) {
            $fan = Auth::guard('fan')->user();
            $fan->addLoginPoints();
            
            return redirect()->route('fan.dashboard')->with('success', 'Welcome back! You earned 1 point for logging in.');
        }

        return back()->withErrors([
            'phone' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function dashboard()
    {
        $fan = Auth::guard('fan')->user();
        $upcomingFixtures = Fixture::with(['homeTeam', 'awayTeam', 'tournament'])
            ->where('match_date', '>=', Carbon::now())
            ->orderBy('match_date')
            ->limit(5)
            ->get();
            
        // Get admin notices for dashboard
        $adminNotices = AdminNotice::forDashboard()
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Get closest vendors in fan's district
        $closestVendors = Vendor::active()
            ->byDistrict($fan->district)
            ->limit(3)
            ->get();
            
        // If no vendors in district, get vendors in same region
        if ($closestVendors->isEmpty()) {
            $closestVendors = Vendor::active()
                ->byRegion($fan->region)
                ->limit(3)
                ->get();
        }
            
        return view('fan.dashboard', compact('fan', 'upcomingFixtures', 'adminNotices', 'closestVendors'));
    }

    public function updateJersey(Request $request)
    {
        $request->validate([
            'favorite_jersey_name' => 'nullable|string|max:20',
            'favorite_jersey_number' => 'nullable|integer|min:1|max:99',
            'favorite_jersey_type' => 'nullable|in:home,away,third',
        ]);

        $fan = Auth::guard('fan')->user();
        $updateData = [
            'favorite_jersey_name' => $request->favorite_jersey_name,
            'favorite_jersey_number' => $request->favorite_jersey_number,
        ];
        
        if ($request->has('favorite_jersey_type')) {
            $updateData['favorite_jersey_type'] = $request->favorite_jersey_type;
        }
        
        $fan->update($updateData);

        return redirect()->route('fan.dashboard')->with('success', 'Jersey details updated successfully!');
    }

    public function logout()
    {
        Auth::guard('fan')->logout();
        return redirect()->route('fan.login')->with('success', 'You have been logged out successfully.');
    }

    // API endpoint for getting districts by region
    public function getDistricts($regionId)
    {
        $districts = District::where('region_id', $regionId)->orderBy('name')->get();
        return response()->json($districts);
    }
}
