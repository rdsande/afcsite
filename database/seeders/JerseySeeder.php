<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jersey;

class JerseySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jerseys = [
            [
                'name' => 'AZAM FC Home Kit 2024/25',
                'type' => 'home',
                'season' => '2024/25',
                'template_image' => 'img/kits/home-2024.svg',
                'customization_options' => [
                    'name_printing' => true,
                    'number_printing' => true,
                    'available_numbers' => range(1, 99),
                    'sizes' => ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
                    'patches' => ['league', 'sponsor', 'captain']
                ],
                'price' => 75000.00, // TSh 75,000
                'is_active' => true,
                'description' => 'Official AZAM FC home jersey for 2024/25 season. Features the classic blue and white design with modern fit.'
            ],
            [
                'name' => 'AZAM FC Away Kit 2024/25',
                'type' => 'away',
                'season' => '2024/25',
                'template_image' => 'img/kits/away-2024.svg',
                'customization_options' => [
                    'name_printing' => true,
                    'number_printing' => true,
                    'available_numbers' => range(1, 99),
                    'sizes' => ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
                    'patches' => ['league', 'sponsor', 'captain']
                ],
                'price' => 75000.00,
                'is_active' => true,
                'description' => 'Official AZAM FC away jersey for 2024/25 season. Features the distinctive away colors with premium fabric.'
            ],
            [
                'name' => 'AZAM FC Third Kit 2024/25',
                'type' => 'third',
                'season' => '2024/25',
                'template_image' => 'img/kits/third-2024.svg',
                'customization_options' => [
                    'name_printing' => true,
                    'number_printing' => true,
                    'available_numbers' => range(1, 99),
                    'sizes' => ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
                    'patches' => ['league', 'sponsor']
                ],
                'price' => 80000.00,
                'is_active' => true,
                'description' => 'Limited edition AZAM FC third kit for 2024/25 season. Unique design celebrating our heritage.'
            ],
            [
                'name' => 'AZAM FC Retro Kit 1980s',
                'type' => 'special',
                'season' => 'Retro',
                'template_image' => 'img/kits/retro-1980.svg',
                'customization_options' => [
                    'name_printing' => true,
                    'number_printing' => true,
                    'available_numbers' => range(1, 23),
                    'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                    'patches' => ['vintage_logo']
                ],
                'price' => 95000.00,
                'is_active' => true,
                'description' => 'Throwback to the golden era! Replica of the classic 1980s AZAM FC jersey with authentic vintage styling.'
            ]
        ];
        
        foreach ($jerseys as $jersey) {
            Jersey::create($jersey);
        }
    }
}
