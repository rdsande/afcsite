<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\AdminNotice;

class MobileAppController extends Controller
{
    /**
     * Get mobile app configuration
     */
    public function getConfig(): JsonResponse
    {
        $config = [
            'app_name' => 'Azam FC',
            'version' => '1.0.0',
            'primary_color' => '#1976D2',
            'secondary_color' => '#1565C0',
            'logo_url' => asset('img/azam.png'),
            'features' => [
                'news' => true,
                'fixtures' => true,
                'players' => true,
                'fan_registration' => true,
                'points_system' => true,
            ],
            'supported_languages' => ['en', 'sw'],
            'default_language' => 'en',
        ];

        return response()->json([
            'success' => true,
            'data' => $config
        ]);
    }

    /**
     * Get splash screen data
     */
    public function getSplashScreen(): JsonResponse
    {
        $splashData = [
            'title' => 'AZAM FOOTBALL CLUB',
            'subtitle' => 'DAR ES SALAAM',
            'company' => 'BAKHRESA GROUP',
            'logo_url' => asset('img/azam.png'),
            'background_color' => '#1976D2',
            'text_color' => '#FFFFFF',
            'features' => [
                'Stay updated with latest news and match results',
                'View upcoming fixtures and team schedules',
                'Explore player profiles and team rosters',
                'Join our fan community and earn points',
                'Get exclusive content and updates',
            ],
            'loading_duration' => 8, // seconds
            'skip_button_delay' => 3, // seconds
        ];

        return response()->json([
            'success' => true,
            'data' => $splashData
        ]);
    }
}
