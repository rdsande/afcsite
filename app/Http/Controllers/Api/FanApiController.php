<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fan;
use App\Models\Region;
use App\Models\District;
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

        return response()->json([
            'success' => true,
            'data' => [
                'points' => $fan->points,
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
