<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SuperAdminSeeder::class,
            TanzaniaLocationSeeder::class,
            CategorySeeder::class,
            TeamSeeder::class,
            PlayerSeeder::class,
            FanSeeder::class,
            JerseySeeder::class,
            FixtureSeeder::class,
            NewsSeeder::class,
            PointTransactionSeeder::class,
            AdminNoticeSeeder::class,
        ]);
    }
}
