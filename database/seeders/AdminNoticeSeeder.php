<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminNotice;
use Carbon\Carbon;

class AdminNoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notices = [
            [
                'title' => 'Welcome to AZAM FC Fan Portal!',
                'content' => 'We are excited to launch our new fan portal. Earn points by logging in daily and when AZAM FC wins matches!',
                'type' => 'success',
                'priority' => 'high',
                'is_active' => true,
                'is_dismissible' => true,
                'show_on_dashboard' => true,
                'show_on_login' => false,
                'created_by' => 1,
                'target_audience' => []
            ],
            [
                'title' => 'New Jersey Customization Feature',
                'content' => 'You can now customize your own AZAM FC jersey! Choose from our available templates and add your name and favorite number.',
                'type' => 'info',
                'priority' => 'medium',
                'is_active' => true,
                'is_dismissible' => true,
                'show_on_dashboard' => true,
                'show_on_login' => false,
                'created_by' => 1,
                'target_audience' => []
            ],
            [
                'title' => 'Upcoming Match: AZAM FC vs Simba SC',
                'content' => 'Don\'t miss our upcoming match against Simba SC this weekend at Benjamin Mkapa Stadium. Get your tickets now!',
                'type' => 'warning',
                'priority' => 'high',
                'is_active' => true,
                'is_dismissible' => false,
                'show_on_dashboard' => true,
                'show_on_login' => true,
                'expires_at' => Carbon::now()->addDays(7),
                'created_by' => 1,
                'target_audience' => []
            ],
            [
                'title' => 'System Maintenance Scheduled',
                'content' => 'We will be performing system maintenance on Sunday from 2:00 AM to 4:00 AM. The portal may be temporarily unavailable during this time.',
                'type' => 'danger',
                'priority' => 'medium',
                'is_active' => true,
                'is_dismissible' => true,
                'show_on_dashboard' => true,
                'show_on_login' => false,
                'starts_at' => Carbon::now()->addDays(2),
                'expires_at' => Carbon::now()->addDays(3),
                'created_by' => 1,
                'target_audience' => []
            ],
            [
                'title' => 'Fan Messaging System Now Available',
                'content' => 'You can now send messages directly to the club management. Use the messaging system to share feedback, ask questions, or report issues.',
                'type' => 'info',
                'priority' => 'low',
                'is_active' => true,
                'is_dismissible' => true,
                'show_on_dashboard' => true,
                'show_on_login' => false,
                'created_by' => 1,
                'target_audience' => []
            ]
        ];

        foreach ($notices as $notice) {
            AdminNotice::create($notice);
        }
    }
}
