<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Azam FC',
                'short_name' => 'Azam',
                'logo' => 'img/teamlogos/azam-fc.png',
                'founded_year' => 2004,
                'home_stadium' => 'Azam Complex',
                'description' => 'Azam Football Club is a Tanzanian football club based in Dar es Salaam that plays in the Tanzanian Premier League.',
                'primary_color' => '#0000FF',
                'secondary_color' => '#FFFFFF',
                'is_active' => true
            ],
            [
                'name' => 'Simba SC',
                'short_name' => 'Simba',
                'logo' => 'img/teamlogos/simba-sc.png',
                'founded_year' => 1936,
                'home_stadium' => 'Benjamin Mkapa Stadium',
                'description' => 'Simba Sports Club is a football club based in Dar es Salaam, Tanzania. Founded in 1936, the club plays in the Tanzanian Premier League.',
                'primary_color' => '#FF0000',
                'secondary_color' => '#FFFFFF',
                'is_active' => true
            ],
            [
                'name' => 'Young Africans SC',
                'short_name' => 'Yanga',
                'logo' => 'img/teamlogos/yanga-sc.png',
                'founded_year' => 1935,
                'home_stadium' => 'Benjamin Mkapa Stadium',
                'description' => 'Young Africans Sports Club is a football club based in Jangwani, Dar es Salaam, Tanzania. Founded in 1935, the club plays in the Tanzanian Premier League.',
                'primary_color' => '#FFFF00',
                'secondary_color' => '#008000',
                'is_active' => true
            ],
            [
                'name' => 'Kagera Sugar FC',
                'short_name' => 'Kagera',
                'logo' => 'img/teamlogos/kagera-sugar.png',
                'founded_year' => 1979,
                'home_stadium' => 'Kaitaba Stadium',
                'description' => 'Kagera Sugar Football Club is a Tanzanian football club based in Bukoba, Kagera Region.',
                'primary_color' => '#008000',
                'secondary_color' => '#FFFFFF',
                'is_active' => true
            ],
            [
                'name' => 'Coastal Union FC',
                'short_name' => 'Coastal',
                'logo' => 'img/teamlogos/coastal-union.png',
                'founded_year' => 1980,
                'home_stadium' => 'Mkwakwani Stadium',
                'description' => 'Coastal Union Football Club is a Tanzanian football club based in Tanga.',
                'primary_color' => '#800080',
                'secondary_color' => '#FFFFFF',
                'is_active' => true
            ],
            [
                'name' => 'Namungo FC',
                'short_name' => 'Namungo',
                'logo' => 'img/teamlogos/namungo-fc.png',
                'founded_year' => 2015,
                'home_stadium' => 'Majaliwa Stadium',
                'description' => 'Namungo Football Club is a Tanzanian football club based in Lindi Region.',
                'primary_color' => '#FFA500',
                'secondary_color' => '#000000',
                'is_active' => true
            ],
            [
                'name' => 'KMC FC',
                'short_name' => 'KMC',
                'logo' => 'img/teamlogos/kmc-fc.png',
                'founded_year' => 2014,
                'home_stadium' => 'Uhuru Stadium',
                'description' => 'Kinondoni Municipal Council Football Club is a Tanzanian football club based in Dar es Salaam.',
                'primary_color' => '#A52A2A',
                'secondary_color' => '#FFFFFF',
                'is_active' => true
            ],
            [
                'name' => 'Mbeya City FC',
                'short_name' => 'Mbeya',
                'logo' => 'img/teamlogos/mbeya-city.png',
                'founded_year' => 2012,
                'home_stadium' => 'Sokoine Stadium',
                'description' => 'Mbeya City Football Club is a Tanzanian football club based in Mbeya.',
                'primary_color' => '#000080',
                'secondary_color' => '#FFFFFF',
                'is_active' => true
            ]
        ];

        foreach ($teams as $team) {
            if (!Team::where('name', $team['name'])->exists()) {
                Team::create($team);
            }
        }
    }
}
