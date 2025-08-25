<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Jersey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display the jersey management page
     */
    public function index()
    {
        $jerseys = Jersey::active()->get();
        $jerseyImage = Setting::get('jersey_image'); // Keep for backward compatibility
        return view('admin.settings.index', compact('jerseys', 'jerseyImage'));
    }

    /**
     * Upload a new jersey
     */
    public function uploadJersey(Request $request)
    {
        $request->validate([
            'jersey_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jersey_type' => 'required|in:home,away,third',
            'jersey_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Deactivate existing jersey of the same type
        Jersey::where('type', $request->jersey_type)
              ->where('is_active', true)
              ->update(['is_active' => false]);

        // Store new jersey image
        $imagePath = $request->file('jersey_image')->store('jerseys', 'public');
        
        // Create new jersey record
        Jersey::create([
            'name' => $request->jersey_name,
            'type' => $request->jersey_type,
            'season' => date('Y') . '/' . date('y', strtotime('+1 year')),
            'template_image' => $imagePath,
            'customization_options' => [
                'name_printing' => true,
                'number_printing' => true,
                'available_numbers' => range(1, 99),
                'sizes' => ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
            ],
            'price' => 0,
            'is_active' => true,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.settings.index')
            ->with('success', ucfirst($request->jersey_type) . ' jersey uploaded successfully!');
    }

    /**
     * Delete a jersey
     */
    public function deleteJersey(Jersey $jersey)
    {
        // Delete the image file
        if ($jersey->template_image && Storage::disk('public')->exists($jersey->template_image)) {
            Storage::disk('public')->delete($jersey->template_image);
        }

        // Delete the jersey record
        $jersey->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Jersey deleted successfully!');
    }

    /**
     * Update jersey image (legacy method for backward compatibility)
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
     * Remove jersey image (legacy method for backward compatibility)
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
