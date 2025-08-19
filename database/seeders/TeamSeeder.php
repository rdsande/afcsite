<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Azam FC',
                'short_name' => 'AZAM',
                'home_stadium' => 'Azam Complex',
                'founded_year' => 2004,
                'description' => 'Azam Football Club is a professional football club based in Dar es Salaam, Tanzania.',
                'primary_color' => '#0066CC',
                'secondary_color' => '#FFFFFF',
                'is_active' => true
            ],
            [
                'name' => 'Young Africans SC',
                'short_name' => 'YANGA',
                'home_stadium' => 'Benjamin Mkapa Stadium',
                'founded_year' => 1935,
                'description' => 'Young Africans Sports Club, commonly referred to as Yanga, is a football club based in Jangwani, Dar es Salaam, Tanzania.',
                'primary_color' => '#FFFF00',
                'secondary_color' => '#008000',
                'is_active' => true
            ],
            [
                'name' => 'Simba SC',
                'short_name' => 'SIMBA',
                'home_stadium' => 'Benjamin Mkapa Stadium',
                'founded_year' => 1936,
                'description' => 'Simba Sports Club is a football club based in Kariakoo, Dar es Salaam, Tanzania.',
                'primary_color' => '#FF0000',
                'secondary_color' => '#FFFFFF',
                'is_active' => true
            ],
            [
                'name' => 'Geita Gold FC',
                'short_name' => 'GEITA',
                'home_stadium' => 'Geita Stadium',
                'founded_year' => 2015,
                'description' => 'Geita Gold Football Club is a professional football club based in Geita, Tanzania.',
                'primary_color' => '#FFD700',
                'secondary_color' => '#000000',
                'is_active' => true
            ],
            [
                'name' => 'Kagera Sugar FC',
                'short_name' => 'KAGERA',
                'home_stadium' => 'Kaitaba Stadium',
                'founded_year' => 1977,
                'description' => 'Kagera Sugar Football Club is a professional football club based in Bukoba, Tanzania.',
                'primary_color' => '#008000',
                'secondary_color' => '#FFFFFF',
                'is_active' => true
            ],
            [
                'name' => 'Namungo FC',
                'short_name' => 'NAMUNGO',
                'home_stadium' => 'Majaliwa Stadium',
                'founded_year' => 2008,
                'description' => 'Namungo Football Club is a professional football club based in Namungo, Lindi, Tanzania.',
                'primary_color' => '#0066FF',
                'secondary_color' => '#FFFFFF',
                'is_active' => true
            ],
            [
                'name' => 'Dodoma Jiji FC',
                'short_name' => 'DODOMA',
                'home_stadium' => 'Jamhuri Stadium',
                'founded_year' => 2010,
                'description' => 'Dodoma Jiji Football Club is a professional football club based in Dodoma, Tanzania.',
                'primary_color' => '#800080',
                'secondary_color' => '#FFFFFF',
                'is_active' => true
            ],
            [
                'name' => 'Ihefu FC',
                'short_name' => 'IHEFU',
                'home_stadium' => 'Sokoine Stadium',
                'founded_year' => 2020,
                'description' => 'Ihefu Football Club is a professional football club based in Iringa, Tanzania.',
                'primary_color' => '#FF6600',
                'secondary_color' => '#000000',
                'is_active' => true
            ]
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
