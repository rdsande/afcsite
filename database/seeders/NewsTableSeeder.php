<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user or create one if not exists
        $admin = User::where('email', 'admin@azamfc.com')->first();
        
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@azamfc.com',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]);
        }

        // Demo posts
        $posts = [
            [
                'title' => 'Azam FC Wins Championship Trophy',
                'excerpt' => 'Azam FC has won the championship trophy after a thrilling final match.',
                'content' => '<p>In an exciting match that kept fans on the edge of their seats, Azam FC emerged victorious in the championship final. The team showcased exceptional skill and teamwork throughout the tournament.</p><p>The winning goal came in the 87th minute, securing their place as champions. Fans erupted in celebration as the final whistle blew, marking a historic moment for the club.</p><p>The team captain expressed gratitude to the supporters, stating that their unwavering support was a crucial factor in their success.</p>',
                'featured_image' => 'img/latest/trophy1.jpg',
                'is_published' => true,
                'is_featured' => true,
                'views' => rand(100, 1000),
            ],
            [
                'title' => 'New Signing: Star Forward Joins Azam FC',
                'excerpt' => 'Azam FC has announced the signing of international star forward to strengthen the squad.',
                'content' => '<p>Azam FC has made a significant addition to their roster by signing international star forward. The player brings a wealth of experience and skill to the team, having previously played in top leagues across Europe.</p><p>The signing is part of the club\'s strategy to strengthen their attacking options ahead of the upcoming season. The new forward expressed excitement about joining Azam FC and is looking forward to contributing to the team\'s success.</p><p>Fans are eagerly anticipating seeing the new signing in action, with many believing this could be the key to securing more silverware in the future.</p>',
                'featured_image' => 'img/latest/player1.jpg',
                'is_published' => true,
                'is_featured' => true,
                'views' => rand(100, 1000),
            ],
            [
                'title' => 'Azam FC Announces New Training Facility',
                'excerpt' => 'The club has unveiled plans for a state-of-the-art training facility to develop talent.',
                'content' => '<p>Azam FC has announced plans for a new state-of-the-art training facility aimed at developing local talent and improving the team\'s performance. The facility will include modern equipment, multiple training pitches, and advanced recovery areas.</p><p>Construction is set to begin next month, with completion expected within a year. The club\'s management believes this investment will pay dividends by enhancing player development and attracting top talent to the team.</p><p>The facility will also include a youth academy, reinforcing the club\'s commitment to nurturing the next generation of football stars.</p>',
                'featured_image' => 'img/latest/facility1.jpg',
                'is_published' => true,
                'is_featured' => false,
                'views' => rand(100, 1000),
            ],
            [
                'title' => 'Azam FC Launches Community Outreach Program',
                'excerpt' => 'The club has initiated a community program to engage with local youth and promote football.',
                'content' => '<p>Azam FC has launched a comprehensive community outreach program aimed at engaging with local youth and promoting football at the grassroots level. The initiative includes free coaching sessions, equipment donations, and school visits by first-team players.</p><p>The program is designed to inspire the next generation of footballers while also strengthening the club\'s connection with the community. Several schools have already signed up for the program, with more expected to join in the coming weeks.</p><p>Club officials emphasized that social responsibility is a core value of Azam FC, and this program represents their commitment to giving back to the community that supports them.</p>',
                'featured_image' => 'img/latest/community1.jpg',
                'is_published' => true,
                'is_featured' => false,
                'views' => rand(100, 1000),
            ],
            [
                'title' => 'Azam FC Player Wins Golden Boot Award',
                'excerpt' => 'Team\'s striker recognized as the league\'s top scorer with impressive goal tally.',
                'content' => '<p>Azam FC\'s star striker has been awarded the prestigious Golden Boot award after finishing the season as the league\'s top scorer. With an impressive tally of goals, the forward demonstrated exceptional skill and consistency throughout the campaign.</p><p>The achievement marks a significant milestone in the player\'s career and brings honor to Azam FC. In a post-award interview, the striker credited teammates and coaching staff for creating opportunities and providing support.</p><p>This is the first time in five years that an Azam FC player has claimed the Golden Boot, highlighting the quality of attacking talent currently at the club.</p>',
                'featured_image' => 'img/latest/award1.jpg',
                'is_published' => true,
                'is_featured' => true,
                'views' => rand(100, 1000),
            ],
        ];

        foreach ($posts as $post) {
            News::create([
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'excerpt' => $post['excerpt'],
                'content' => $post['content'],
                'featured_image' => $post['featured_image'],
                'is_published' => $post['is_published'],
                'is_featured' => $post['is_featured'],
                'published_at' => now(),
                'author_id' => $admin->id,
                'views' => $post['views'],
            ]);
        }
    }
}
