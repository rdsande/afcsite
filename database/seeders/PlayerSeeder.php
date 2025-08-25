<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Player;
use Illuminate\Support\Facades\DB;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('players')->delete();
        
        $players = [
            [
                'name' => 'Feisal Salum',
                'position' => 'Goalkeeper',
                'jersey_number' => 1,
                'team_category' => 'first_team',
                'date_of_birth' => '1996-01-15',
                'nationality' => 'Tanzania',
                'height' => 1.85,
                'biography' => 'Experienced goalkeeper with excellent reflexes and leadership qualities.',
                'goals_inside_box' => 0,
                'goals_outside_box' => 0,
                'assists' => 0,
                'is_active' => true,
                'is_captain' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dickson Job',
                'position' => 'Defender',
                'jersey_number' => 2,
                'team_category' => 'first_team',
                'date_of_birth' => '1998-03-22',
                'nationality' => 'Tanzania',
                'height' => 1.78,
                'biography' => 'Solid defender with good aerial ability and crossing skills.',
                'goals_inside_box' => 2,
                'goals_outside_box' => 1,
                'assists' => 5,
                'is_active' => true,
                'is_captain' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Prince Dube',
                'position' => 'Forward',
                'jersey_number' => 11,
                'team_category' => 'first_team',
                'date_of_birth' => '1997-05-10',
                'nationality' => 'Zimbabwe',
                'height' => 1.82,
                'biography' => 'Clinical striker with excellent finishing and positioning in the box.',
                'goals_inside_box' => 15,
                'goals_outside_box' => 3,
                'assists' => 7,
                'is_active' => true,
                'is_captain' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mudathir Yahya',
                'position' => 'Midfielder',
                'jersey_number' => 8,
                'team_category' => 'first_team',
                'date_of_birth' => '1999-08-18',
                'nationality' => 'Tanzania',
                'height' => 1.75,
                'biography' => 'Creative midfielder with excellent passing range and vision.',
                'goals_inside_box' => 4,
                'goals_outside_box' => 2,
                'assists' => 12,
                'is_active' => true,
                'is_captain' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kelvin Yondani',
                'position' => 'Defender',
                'jersey_number' => 5,
                'team_category' => 'first_team',
                'date_of_birth' => '2000-02-28',
                'nationality' => 'Tanzania',
                'height' => 1.80,
                'biography' => 'Young and promising center-back with good pace and tackling.',
                'goals_inside_box' => 1,
                'goals_outside_box' => 1,
                'assists' => 1,
                'is_active' => true,
                'is_captain' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($players as $player) {
            Player::create($player);
        }
    }
}
