<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display the settings page
     */
    public function index()
    {
        $jerseyImage = Setting::get('jersey_image');
        return view('admin.settings.index', compact('jerseyImage'));
    }

    /**
     * Update jersey image
     */
    public function updateJerseyImage(Request $request)
    {
        $request->validate([
            'jersey_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Delete old jersey image if exists
        $oldImage = Setting::get('jersey_image');
        if ($oldImage && Storage::disk('public')->exists($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }

        // Store new jersey image
        $imagePath = $request->file('jersey_image')->store('jerseys', 'public');
        
        // Update setting
        Setting::set('jersey_image', $imagePath, 'image');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Jersey image updated successfully!');
    }

    /**
     * Remove jersey image (revert to default)
     */
    public function removeJerseyImage()
    {
        $oldImage = Setting::get('jersey_image');
        if ($oldImage && Storage::disk('public')->exists($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }

        Setting::where('key', 'jersey_image')->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Jersey image removed. Using default image.');
    }
}
