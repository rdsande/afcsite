<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and users for relationships
        $categories = Category::all();
        $users = User::all();
        
        if ($categories->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Categories or Users not found. Please run CategorySeeder and SuperAdminSeeder first.');
            return;
        }

        $latestNewsCategory = $categories->where('slug', 'latest-news')->first();
        $breakingNewsCategory = $categories->where('slug', 'breaking-news')->first();
        $articlesCategory = $categories->where('slug', 'articles')->first();
        $updatesCategory = $categories->where('slug', 'updates')->first();
        $academyCategory = $categories->where('slug', 'academy-news')->first();
        
        $author = $users->first();

        $newsArticles = [
            [
                'title' => 'AZAM FC Wins 3-1 Against Simba SC in Thrilling Derby',
                'slug' => 'azam-fc-wins-3-1-against-simba-sc-thrilling-derby',
                'excerpt' => 'AZAM FC delivered a spectacular performance defeating Simba SC 3-1 in the highly anticipated Dar es Salaam derby at Benjamin Mkapa Stadium.',
                'content' => '<p>AZAM FC delivered a spectacular performance defeating Simba SC 3-1 in the highly anticipated Dar es Salaam derby at Benjamin Mkapa Stadium. The match, which attracted over 60,000 fans, showcased the best of Tanzanian football.</p><p>The Ice Cream Makers took the lead in the 15th minute through a brilliant strike from their captain, followed by two more goals in the second half. Despite Simba\'s late consolation goal, AZAM FC maintained their composure to secure all three points.</p><p>This victory moves AZAM FC to the top of the league table and demonstrates their championship ambitions for this season.</p>',
                'featured_image' => 'img/latest/azam-vs-simba-derby.jpg',
                'category_id' => $breakingNewsCategory->id,
                'author_id' => $author->id,
                'is_published' => true,
                'is_featured' => true,
                'published_at' => Carbon::now()->subDays(1),
                'views' => 1250,
            ],
            [
                'title' => 'New Signing: Brazilian Midfielder Joins AZAM FC',
                'slug' => 'new-signing-brazilian-midfielder-joins-azam-fc',
                'excerpt' => 'AZAM FC announces the signing of talented Brazilian midfielder Carlos Silva on a two-year contract.',
                'content' => '<p>AZAM FC is delighted to announce the signing of Brazilian midfielder Carlos Silva on a two-year contract. The 26-year-old brings extensive experience from the Brazilian Serie A and is expected to strengthen our midfield significantly.</p><p>Silva, who has represented Brazil at youth levels, expressed his excitement about joining the Ice Cream Makers and contributing to the team\'s success in both domestic and continental competitions.</p><p>The midfielder will wear jersey number 10 and is expected to make his debut in the upcoming fixture against Young Africans SC.</p>',
                'featured_image' => 'img/latest/carlos-silva-signing.jpg',
                'category_id' => $latestNewsCategory->id,
                'author_id' => $author->id,
                'is_published' => true,
                'is_featured' => true,
                'published_at' => Carbon::now()->subDays(3),
                'views' => 890,
            ],
            [
                'title' => 'AZAM FC Academy Graduates Shine in Youth Tournament',
                'slug' => 'azam-fc-academy-graduates-shine-youth-tournament',
                'excerpt' => 'Three AZAM FC academy graduates have been selected for the national youth team following impressive performances in the regional tournament.',
                'content' => '<p>AZAM FC\'s youth development program continues to bear fruit as three academy graduates have been selected for the Tanzania national youth team. The players - John Mwalimu, Peter Kimaro, and David Msigwa - impressed scouts during the recent regional youth tournament.</p><p>This achievement highlights the quality of AZAM FC\'s youth development system and our commitment to nurturing local talent. The academy has produced over 20 professional players in the past five years.</p><p>Head of Academy, Coach Mohamed Ally, praised the dedication of the young players and the support from the club management in developing future stars.</p>',
                'featured_image' => 'img/latest/academy-success.jpg',
                'category_id' => $academyCategory->id,
                'author_id' => $author->id,
                'is_published' => true,
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(5),
                'views' => 456,
            ],
            [
                'title' => 'Stadium Renovation Project Nears Completion',
                'slug' => 'stadium-renovation-project-nears-completion',
                'excerpt' => 'The AZAM Complex renovation project is 90% complete, with new facilities set to enhance fan experience.',
                'content' => '<p>The ambitious renovation project at AZAM Complex is nearing completion, with 90% of the work already finished. The project includes upgraded seating, improved lighting, modern changing rooms, and enhanced security systems.</p><p>The renovated stadium will have a capacity of 15,000 and will meet CAF standards for continental competitions. New VIP lounges and hospitality suites have been added to improve the matchday experience for supporters.</p><p>Club Chairman, Mr. Said Bakhresa, expressed satisfaction with the progress and confirmed that the stadium will be ready for the new season. The first match at the renovated facility is scheduled for next month.</p>',
                'featured_image' => 'img/latest/stadium-renovation.jpg',
                'category_id' => $updatesCategory->id,
                'author_id' => $author->id,
                'is_published' => true,
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(7),
                'views' => 678,
            ],
            [
                'title' => 'Coach Aristica Cioaba Extends Contract Until 2026',
                'slug' => 'coach-aristica-cioaba-extends-contract-until-2026',
                'excerpt' => 'Head coach Aristica Cioaba has signed a contract extension, keeping him at AZAM FC until 2026.',
                'content' => '<p>AZAM FC is pleased to announce that head coach Aristica Cioaba has signed a contract extension that will keep him at the club until 2026. The Romanian tactician has transformed the team since his arrival, implementing an attractive style of play.</p><p>Under Cioaba\'s guidance, AZAM FC has shown significant improvement in both domestic and continental competitions. His tactical acumen and ability to develop young players have impressed the club management.</p><p>"I am very happy to continue my journey with AZAM FC. We have built something special here, and I believe we can achieve great things together," said Coach Cioaba during the contract signing ceremony.</p>',
                'featured_image' => 'img/latest/coach-contract-extension.jpg',
                'category_id' => $latestNewsCategory->id,
                'author_id' => $author->id,
                'is_published' => true,
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(10),
                'views' => 723,
            ],
            [
                'title' => 'AZAM FC Launches Community Outreach Program',
                'slug' => 'azam-fc-launches-community-outreach-program',
                'excerpt' => 'The club announces a comprehensive community program focusing on education and youth development in Dar es Salaam.',
                'content' => '<p>AZAM FC has launched an ambitious community outreach program aimed at supporting education and youth development in Dar es Salaam. The program, titled "Ice Cream Dreams," will benefit over 1,000 children in the next year.</p><p>The initiative includes scholarship programs for academically gifted students, football coaching clinics in underserved communities, and the construction of mini-pitches in various neighborhoods.</p><p>Club CEO, Abdulkarim Amin, emphasized the club\'s commitment to giving back to the community that has supported them throughout their journey. The program will be officially launched next week with a ceremony at the AZAM Complex.</p>',
                'featured_image' => 'img/latest/community-program.jpg',
                'category_id' => $articlesCategory->id,
                'author_id' => $author->id,
                'is_published' => true,
                'is_featured' => false,
                'published_at' => Carbon::now()->subDays(12),
                'views' => 534,
            ],
        ];

        foreach ($newsArticles as $article) {
            News::create($article);
        }

        $this->command->info('News articles seeded successfully!');
    }
}