<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MobileAppSettingsController extends Controller
{
    /**
     * Display the mobile app settings page
     */
    public function index()
    {
        $settings = $this->getAppSettings();
        return view('admin.mobile-app.settings', compact('settings'));
    }

    /**
     * Update app configuration
     */
    public function updateConfig(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'app_name' => 'required|string|max:255',
            'app_version' => 'required|string|max:20',
            'welcome_title' => 'required|string|max:255',
            'welcome_message' => 'required|string|max:1000',
            'team_name' => 'required|string|max:255',
            'team_description' => 'nullable|string|max:1000',
            'primary_color' => 'required|string|max:7',
            'secondary_color' => 'required|string|max:7',
            'enable_notifications' => 'boolean',
            'enable_shop' => 'boolean',
            'enable_news' => 'boolean',
            'enable_fixtures' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $settings = [
                'app_name' => $request->app_name,
                'app_version' => $request->app_version,
                'welcome_title' => $request->welcome_title,
                'welcome_message' => $request->welcome_message,
                'team_name' => $request->team_name,
                'team_description' => $request->team_description,
                'primary_color' => $request->primary_color,
                'secondary_color' => $request->secondary_color,
                'enable_notifications' => $request->boolean('enable_notifications'),
                'enable_shop' => $request->boolean('enable_shop'),
                'enable_news' => $request->boolean('enable_news'),
                'enable_fixtures' => $request->boolean('enable_fixtures'),
                'updated_at' => now()->toISOString()
            ];

            Storage::put('mobile-app/config.json', json_encode($settings, JSON_PRETTY_PRINT));

            return redirect()->back()->with('success', 'App configuration updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update configuration: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Upload app logo
     */
    public function uploadLogo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Delete old logo if exists
            if (Storage::exists('mobile-app/logo.png')) {
                Storage::delete('mobile-app/logo.png');
            }

            // Store new logo
            $path = $request->file('logo')->storeAs('mobile-app', 'logo.png', 'public');

            return redirect()->back()->with('success', 'Logo uploaded successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to upload logo: ' . $e->getMessage());
        }
    }

    /**
     * Upload splash screen images
     */
    public function uploadSplashScreen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'splash_screen' => 'required|image|mimes:png,jpg,jpeg|max:5120',
            'screen_type' => 'required|in:welcome,advantages,language'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $screenType = $request->screen_type;
            $filename = "splash_{$screenType}.png";

            // Delete old splash screen if exists
            if (Storage::exists("mobile-app/{$filename}")) {
                Storage::delete("mobile-app/{$filename}");
            }

            // Store new splash screen
            $path = $request->file('splash_screen')->storeAs('mobile-app', $filename, 'public');

            return redirect()->back()->with('success', ucfirst($screenType) . ' splash screen uploaded successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to upload splash screen: ' . $e->getMessage());
        }
    }

    /**
     * Manage app advantages
     */
    public function updateAdvantages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'advantages' => 'required|array|min:1|max:5',
            'advantages.*.title' => 'required|string|max:255',
            'advantages.*.description' => 'required|string|max:500',
            'advantages.*.icon' => 'nullable|string|max:50'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $advantages = [];
            foreach ($request->advantages as $advantage) {
                $advantages[] = [
                    'title' => $advantage['title'],
                    'description' => $advantage['description'],
                    'icon' => $advantage['icon'] ?? 'star'
                ];
            }

            Storage::put('mobile-app/advantages.json', json_encode($advantages, JSON_PRETTY_PRINT));

            return redirect()->back()->with('success', 'App advantages updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update advantages: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Get current app settings
     */
    private function getAppSettings()
    {
        $defaultSettings = [
            'app_name' => 'Azam FC',
            'app_version' => '1.0.0',
            'welcome_title' => 'Welcome to Azam FC',
            'welcome_message' => 'Stay connected with your favorite team. Get the latest news, fixtures, and exclusive content.',
            'team_name' => 'Azam FC',
            'team_description' => 'Tanzania Premier League Football Club',
            'primary_color' => '#1E40AF',
            'secondary_color' => '#F59E0B',
            'enable_notifications' => true,
            'enable_shop' => true,
            'enable_news' => true,
            'enable_fixtures' => true,
        ];

        if (Storage::exists('mobile-app/config.json')) {
            $storedSettings = json_decode(Storage::get('mobile-app/config.json'), true);
            return array_merge($defaultSettings, $storedSettings);
        }

        return $defaultSettings;
    }

    /**
     * Get app advantages
     */
    public function getAdvantages()
    {
        $defaultAdvantages = [
            [
                'title' => 'Latest News',
                'description' => 'Stay updated with the latest team news and match reports',
                'icon' => 'newspaper'
            ],
            [
                'title' => 'Live Fixtures',
                'description' => 'Never miss a match with our comprehensive fixture list',
                'icon' => 'calendar'
            ],
            [
                'title' => 'Official Shop',
                'description' => 'Get authentic team merchandise delivered to your door',
                'icon' => 'shopping-bag'
            ],
            [
                'title' => 'Player Stats',
                'description' => 'Follow your favorite players and their performance',
                'icon' => 'users'
            ]
        ];

        if (Storage::exists('mobile-app/advantages.json')) {
            return json_decode(Storage::get('mobile-app/advantages.json'), true);
        }

        return $defaultAdvantages;
    }

    /**
     * Reset to default settings
     */
    public function resetToDefaults()
    {
        try {
            // Delete custom config files
            Storage::delete([
                'mobile-app/config.json',
                'mobile-app/advantages.json'
            ]);

            return redirect()->back()->with('success', 'Settings reset to defaults successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to reset settings: ' . $e->getMessage());
        }
    }

    /**
     * Preview mobile app configuration
     */
    public function preview()
    {
        $settings = $this->getAppSettings();
        $advantages = $this->getAdvantages();
        
        return response()->json([
            'success' => true,
            'data' => [
                'settings' => $settings,
                'advantages' => $advantages,
                'assets' => [
                    'logo' => Storage::exists('mobile-app/logo.png') ? Storage::url('mobile-app/logo.png') : null,
                    'splash_welcome' => Storage::exists('mobile-app/splash_welcome.png') ? Storage::url('mobile-app/splash_welcome.png') : null,
                    'splash_advantages' => Storage::exists('mobile-app/splash_advantages.png') ? Storage::url('mobile-app/splash_advantages.png') : null,
                    'splash_language' => Storage::exists('mobile-app/splash_language.png') ? Storage::url('mobile-app/splash_language.png') : null,
                ]
            ]
        ]);
    }
}