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
            UsersTableSeeder::class,
            TeamsTableSeeder::class,
            PlayersTableSeeder::class,
            LeaguesTableSeeder::class,
            MatchesTableSeeder::class,
            CategorySeeder::class,
            NewsTableSeeder::class,
            RegionsTableSeeder::class,
            VendorsTableSeeder::class,
            FansTableSeeder::class,
        ]);
    }
}
