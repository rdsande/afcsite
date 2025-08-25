<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fan;
use App\Models\Region;
use App\Models\District;
use App\Models\Jersey;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class FanApiController extends Controller
{
    /**
     * Register a new fan
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:fans',
            'phone' => 'required|string|max:20|unique:fans',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'region' => 'required|string|max:255',
            'district' => 'required|string|max:255',
        ]);

        $fan = Fan::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'region' => $request->region,
            'district' => $request->district,
            'points' => 0,
        ]);

        $token = $fan->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Fan registered successfully',
            'data' => [
                'fan' => $fan,
                'token' => $token
            ]
        ], 201);
    }

    /**
     * Fan login
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        $fan = Fan::where('phone', $request->phone)->first();

        if (!$fan || !Hash::check($request->password, $fan->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $fan->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'fan' => $fan,
                'token' => $token
            ]
        ]);
    }

    /**
     * Get fan profile
     */
    public function profile(Request $request): JsonResponse
    {
        $fan = $request->user();

        return response()->json([
            'success' => true,
            'data' => $fan
        ]);
    }

    /**
     * Update fan profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $fan = $request->user();

        $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20|unique:fans,phone,' . $fan->id,
            'region' => 'sometimes|string|max:255',
            'district' => 'sometimes|string|max:255',
            'profile_image' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fan->update($request->only(['first_name', 'last_name', 'phone', 'region', 'district']));

        if ($request->hasFile('profile_image')) {
            // Handle profile image upload
            $path = $request->file('profile_image')->store('fan-profiles', 'public');
            $fan->update(['profile_image' => $path]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $fan
        ]);
    }

    /**
     * Fan logout
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Get fan points
     */
    public function getPoints(Request $request): JsonResponse
    {
        $fan = $request->user();

        // Get points breakdown by type
        $loginPoints = $fan->getPointsByType('login');
        $teamWinPoints = $fan->getPointsByType('win');
        $bonusPoints = $fan->getPointsByType('bonus') + $fan->getPointsByType('admin_bonus') + $fan->getPointsByType('manual');

        return response()->json([
            'success' => true,
            'data' => [
                'total_points' => $fan->points,
                'daily_login_points' => $loginPoints,
                'match_points' => $teamWinPoints,
                'bonus_points' => $bonusPoints,
                'level' => $this->calculateLevel($fan->points)
            ]
        ]);
    }

    /**
     * Get all regions
     */
    public function getRegions(): JsonResponse
    {
        try {
            $regions = Region::orderBy('name')->get(['id', 'name']);
            
            return response()->json([
                'success' => true,
                'data' => $regions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch regions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get districts by region ID
     */
    public function getDistricts($regionId): JsonResponse
    {
        try {
            $districts = District::where('region_id', $regionId)
                ->orderBy('name')
                ->get(['id', 'name', 'region_id']);
            
            return response()->json([
                'success' => true,
                'data' => $districts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch districts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all fans for public display
     */
    public function getAllFans(Request $request): JsonResponse
    {
        try {
            $query = Fan::select([
                'id',
                'first_name',
                'last_name',
                'region',
                'district',
                'points',
                'profile_image',
                'created_at'
            ]);

            // Add search functionality
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('region', 'like', "%{$search}%")
                      ->orWhere('district', 'like', "%{$search}%");
                });
            }

            // Filter by region
            if ($request->filled('region')) {
                $query->where('region', $request->region);
            }

            // Sort by points (highest first) or name
            $sortBy = $request->get('sort_by', 'points');
            $sortOrder = $request->get('sort_order', 'desc');
            
            if ($sortBy === 'name') {
                $query->orderBy('first_name', $sortOrder)
                      ->orderBy('last_name', $sortOrder);
            } else {
                $query->orderBy($sortBy, $sortOrder);
            }

            // Paginate results
            $perPage = min($request->get('per_page', 20), 50); // Max 50 per page
            $fans = $query->paginate($perPage);

            // Add level to each fan
            $fans->getCollection()->transform(function ($fan) {
                $fan->level = $this->calculateLevel($fan->points);
                $fan->full_name = $fan->first_name . ' ' . $fan->last_name;
                return $fan;
            });

            return response()->json([
                'success' => true,
                'data' => $fans->items(),
                'pagination' => [
                    'current_page' => $fans->currentPage(),
                    'last_page' => $fans->lastPage(),
                    'per_page' => $fans->perPage(),
                    'total' => $fans->total(),
                    'from' => $fans->firstItem(),
                    'to' => $fans->lastItem(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch fans',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get fan jersey details
     */
    public function getJersey(Request $request): JsonResponse
    {
        $fan = $request->user();
        $jerseyType = $fan->favorite_jersey_type ?? 'home';
        
        // Get the active jersey for the fan's preferred type
        $jersey = Jersey::active()->byType($jerseyType)->first();
        
        return response()->json([
            'success' => true,
            'data' => [
                'jersey_name' => $fan->favorite_jersey_name ?? 'AZAM FAN',
                'jersey_number' => $fan->favorite_jersey_number ?? 1,
                'jersey_type' => $jerseyType,
                'fan_name' => strtoupper($fan->first_name . ' ' . $fan->last_name),
                'jersey_image_url' => $jersey && $jersey->template_image ? asset('storage/jerseys/' . $jersey->template_image) : null,
                'jersey_display_name' => $jersey ? $jersey->name : ucfirst($jerseyType) . ' Jersey',
            ]
        ]);
    }

    /**
     * Update fan jersey details
     */
    public function updateJersey(Request $request): JsonResponse
    {
        $request->validate([
            'jersey_name' => 'required|string|max:20',
            'jersey_number' => 'required|integer|min:1|max:99',
            'jersey_type' => 'sometimes|in:home,away,third',
        ]);

        $fan = $request->user();
        $updateData = [
            'favorite_jersey_name' => strtoupper($request->jersey_name),
            'favorite_jersey_number' => $request->jersey_number,
        ];
        
        if ($request->has('jersey_type')) {
            $updateData['favorite_jersey_type'] = $request->jersey_type;
        }
        
        $fan->update($updateData);
        
        // Get the updated jersey information
        $jerseyType = $fan->favorite_jersey_type;
        $jersey = Jersey::active()->byType($jerseyType)->first();

        return response()->json([
            'success' => true,
            'message' => 'Jersey details updated successfully',
            'data' => [
                'jersey_name' => $fan->favorite_jersey_name,
                'jersey_number' => $fan->favorite_jersey_number,
                'jersey_type' => $fan->favorite_jersey_type,
                'fan_name' => strtoupper($fan->first_name . ' ' . $fan->last_name),
                'jersey_image_url' => $jersey && $jersey->template_image ? asset('storage/jerseys/' . $jersey->template_image) : null,
                'jersey_display_name' => $jersey ? $jersey->name : ucfirst($jerseyType) . ' Jersey',
            ]
        ]);
    }

    /**
     * Calculate fan level based on points
     */
    private function calculateLevel(int $points): string
    {
        if ($points >= 1000) return 'Legend';
        if ($points >= 500) return 'Super Fan';
        if ($points >= 200) return 'Loyal Fan';
        if ($points >= 50) return 'Regular Fan';
        return 'New Fan';
    }
}
