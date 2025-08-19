<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Latest News',
                'slug' => 'latest-news',
                'description' => 'Most recent news and updates',
                'color' => '#007bff',
                'sort_order' => 1
            ],
            [
                'name' => 'Breaking News',
                'slug' => 'breaking-news',
                'description' => 'Urgent and important news updates',
                'color' => '#dc3545',
                'sort_order' => 2
            ],
            [
                'name' => 'Academy News',
                'slug' => 'academy-news',
                'description' => 'News related to academy activities and programs',
                'color' => '#28a745',
                'sort_order' => 3
            ],
            [
                'name' => 'Articles',
                'slug' => 'articles',
                'description' => 'In-depth articles and analysis',
                'color' => '#6f42c1',
                'sort_order' => 4
            ],
            [
                'name' => 'Updates',
                'slug' => 'updates',
                'description' => 'General updates and announcements',
                'color' => '#fd7e14',
                'sort_order' => 5
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
