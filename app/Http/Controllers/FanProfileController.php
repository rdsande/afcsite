<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class FanProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:fan');
    }

    public function show()
    {
        $fan = Auth::guard('fan')->user();
        return view('fan.profile.show', compact('fan'));
    }

    public function edit()
    {
        $fan = Auth::guard('fan')->user();
        return view('fan.profile.edit', compact('fan'));
    }

    public function update(Request $request)
    {
        $fan = Auth::guard('fan')->user();
        
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:fans,email,' . $fan->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'current_password:fan'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $fan->first_name = $request->first_name;
        $fan->last_name = $request->last_name;
        $fan->email = $request->email;
        $fan->phone = $request->phone;

        if ($request->filled('password')) {
            $fan->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_image')) {
            // Delete old profile image if exists
            if ($fan->profile_image && Storage::disk('public')->exists($fan->profile_image)) {
                Storage::disk('public')->delete($fan->profile_image);
            }

            // Store new profile image
            $path = $request->file('profile_image')->store('fan-profile-images', 'public');
            $fan->profile_image = $path;
        }

        $fan->save();

        return redirect()->route('fan.profile.show')->with('success', 'Profile updated successfully!');
    }

    public function deleteImage()
    {
        $fan = Auth::guard('fan')->user();
        
        if ($fan->profile_image && Storage::disk('public')->exists($fan->profile_image)) {
            Storage::disk('public')->delete($fan->profile_image);
            $fan->profile_image = null;
            $fan->save();
        }

        return redirect()->route('fan.profile.edit')->with('success', 'Profile image deleted successfully!');
    }
}
