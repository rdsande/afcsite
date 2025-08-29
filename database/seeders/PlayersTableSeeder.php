<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Player;
use Illuminate\Support\Str;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $players = [
            // Azam FC Players
            [
                'name' => 'David Mapigano',
                'slug' => Str::slug('David Mapigano'),
                'position' => 'Goalkeeper',
                'jersey_number' => 1,
                'team_category' => 'First Team',
                'date_of_birth' => '1996-05-15',
                'nationality' => 'Tanzania',
                'height' => 188,
                'weight' => 82,
                'preferred_foot' => 'right',
                'biography' => 'David Mapigano is an experienced goalkeeper who joined Azam FC after a successful stint with other clubs.',
                'profile_image' => 'img/players/player1.jpg',
                'is_active' => true,
                'is_captain' => false,
            ],
            [
                'name' => 'Lusajo Mwaikenda',
                'slug' => Str::slug('Lusajo Mwaikenda'),
                'position' => 'Defender',
                'jersey_number' => 2,
                'team_category' => 'First Team',
                'date_of_birth' => '1997-03-22',
                'nationality' => 'Tanzania',
                'height' => 182,
                'weight' => 78,
                'preferred_foot' => 'right',
                'biography' => 'Lusajo Mwaikenda is a solid defender known for his tackling ability and leadership on the field.',
                'profile_image' => 'img/players/player2.jpg',
                'is_active' => true,
                'is_captain' => false,
            ],
            [
                'name' => 'Edward Manyama',
                'slug' => Str::slug('Edward Manyama'),
                'position' => 'Midfielder',
                'jersey_number' => 8,
                'team_category' => 'First Team',
                'date_of_birth' => '1995-07-10',
                'nationality' => 'Tanzania',
                'height' => 175,
                'weight' => 70,
                'preferred_foot' => 'right',
                'biography' => 'Edward Manyama is a creative midfielder with excellent vision and passing ability.',
                'profile_image' => 'img/players/player3.jpg',
                'is_active' => true,
                'is_captain' => true,
            ],
            [
                'name' => 'Prince Dube',
                'slug' => Str::slug('Prince Dube'),
                'position' => 'Forward',
                'jersey_number' => 9,
                'team_category' => 'First Team',
                'date_of_birth' => '1997-02-18',
                'nationality' => 'Zimbabwe',
                'height' => 180,
                'weight' => 75,
                'preferred_foot' => 'left',
                'biography' => 'Prince Dube is a prolific striker who has represented his national team and scored many important goals for Azam FC.',
                'profile_image' => 'img/players/player4.jpg',
                'is_active' => true,
                'is_captain' => false,
            ],
            [
                'name' => 'Iddi Selemani',
                'slug' => Str::slug('Iddi Selemani'),
                'position' => 'Forward',
                'jersey_number' => 11,
                'team_category' => 'First Team',
                'date_of_birth' => '1998-09-05',
                'nationality' => 'Tanzania',
                'height' => 178,
                'weight' => 72,
                'preferred_foot' => 'right',
                'biography' => 'Iddi Selemani is a fast winger known for his dribbling skills and ability to create chances.',
                'profile_image' => 'img/players/player5.jpg',
                'is_active' => true,
                'is_captain' => false,
            ],
            
            // Simba SC Players
            [
                'name' => 'Aishi Manula',
                'slug' => Str::slug('Aishi Manula'),
                'position' => 'Goalkeeper',
                'jersey_number' => 1,
                'team_category' => 'First Team',
                'date_of_birth' => '1995-01-30',
                'nationality' => 'Tanzania',
                'height' => 186,
                'weight' => 80,
                'preferred_foot' => 'right',
                'biography' => 'Aishi Manula is the first-choice goalkeeper for both Simba SC and the Tanzania national team.',
                'profile_image' => 'img/players/player6.jpg',
                'is_active' => true,
                'is_captain' => false,
            ],
            [
                'name' => 'Shomari Kapombe',
                'slug' => Str::slug('Shomari Kapombe'),
                'position' => 'Defender',
                'jersey_number' => 2,
                'team_category' => 'First Team',
                'date_of_birth' => '1992-06-12',
                'nationality' => 'Tanzania',
                'height' => 175,
                'weight' => 70,
                'preferred_foot' => 'right',
                'biography' => 'Shomari Kapombe is an experienced defender who has been a key player for Simba SC for many years.',
                'profile_image' => 'img/players/player7.jpg',
                'is_active' => true,
                'is_captain' => true,
            ],
            
            // Yanga SC Players
            [
                'name' => 'Metacha Mnata',
                'slug' => Str::slug('Metacha Mnata'),
                'position' => 'Goalkeeper',
                'jersey_number' => 1,
                'team_category' => 'First Team',
                'date_of_birth' => '1994-11-08',
                'nationality' => 'Tanzania',
                'height' => 187,
                'weight' => 81,
                'preferred_foot' => 'right',
                'biography' => 'Metacha Mnata is a talented goalkeeper who has established himself as the first choice for Young Africans SC.',
                'profile_image' => 'img/players/player8.jpg',
                'is_active' => true,
                'is_captain' => false,
            ],
            [
                'name' => 'Bakari Mwamnyeto',
                'slug' => Str::slug('Bakari Mwamnyeto'),
                'position' => 'Defender',
                'jersey_number' => 3,
                'team_category' => 'First Team',
                'date_of_birth' => '1996-04-25',
                'nationality' => 'Tanzania',
                'height' => 183,
                'weight' => 76,
                'preferred_foot' => 'right',
                'biography' => 'Bakari Mwamnyeto is a strong central defender who joined Young Africans SC after impressing with his previous club.',
                'profile_image' => 'img/players/player9.jpg',
                'is_active' => true,
                'is_captain' => true,
            ],
        ];

        foreach ($players as $player) {
            if (!Player::where('name', $player['name'])->exists()) {
                Player::create($player);
            }
        }
    }
}
