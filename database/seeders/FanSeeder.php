<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fan;
use Illuminate\Support\Facades\Hash;

class FanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fans = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+255123456789',
                'password' => Hash::make('password'),
                'gender' => 'male',
                'date_of_birth' => '1990-01-15',
                'region' => 'Dar es Salaam',
                'district' => 'Kinondoni',
                'points' => 150,
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+255987654321',
                'password' => Hash::make('password'),
                'gender' => 'female',
                'date_of_birth' => '1992-05-20',
                'region' => 'Arusha',
                'district' => 'Arusha Urban',
                'points' => 280,
            ],
            [
                'first_name' => 'Mohamed',
                'last_name' => 'Hassan',
                'email' => 'mohamed.hassan@example.com',
                'phone' => '+255456789123',
                'password' => Hash::make('password'),
                'gender' => 'male',
                'date_of_birth' => '1988-11-10',
                'region' => 'Mwanza',
                'district' => 'Nyamagana',
                'points' => 420,
            ],
            [
                'first_name' => 'Fatima',
                'last_name' => 'Ali',
                'email' => 'fatima.ali@example.com',
                'phone' => '+255789123456',
                'password' => Hash::make('password'),
                'gender' => 'female',
                'date_of_birth' => '1995-03-08',
                'region' => 'Dodoma',
                'district' => 'Dodoma Urban',
                'points' => 95,
            ],
            [
                'first_name' => 'Peter',
                'last_name' => 'Mwangi',
                'email' => 'peter.mwangi@example.com',
                'phone' => '+255321654987',
                'password' => Hash::make('password'),
                'gender' => 'male',
                'date_of_birth' => '1987-07-25',
                'region' => 'Kilimanjaro',
                'district' => 'Moshi Urban',
                'points' => 340,
            ],
            [
                'first_name' => 'Grace',
                'last_name' => 'Mbeki',
                'email' => 'grace.mbeki@example.com',
                'phone' => '+255654321789',
                'password' => Hash::make('password'),
                'gender' => 'female',
                'date_of_birth' => '1993-12-03',
                'region' => 'Dar es Salaam',
                'district' => 'Ilala',
                'points' => 210,
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Kimani',
                'email' => 'david.kimani@example.com',
                'phone' => '+255147258369',
                'password' => Hash::make('password'),
                'gender' => 'male',
                'date_of_birth' => '1991-09-18',
                'region' => 'Mbeya',
                'district' => 'Mbeya Urban',
                'points' => 185,
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Juma',
                'email' => 'sarah.juma@example.com',
                'phone' => '+255963852741',
                'password' => Hash::make('password'),
                'gender' => 'female',
                'date_of_birth' => '1989-04-12',
                'region' => 'Tanga',
                'district' => 'Tanga Urban',
                'points' => 315,
            ],
            [
                'first_name' => 'Emmanuel',
                'last_name' => 'Moshi',
                'email' => 'emmanuel.moshi@example.com',
                'phone' => '+255852741963',
                'password' => Hash::make('password'),
                'gender' => 'male',
                'date_of_birth' => '1994-06-30',
                'region' => 'Morogoro',
                'district' => 'Morogoro Urban',
                'points' => 125,
            ],
            [
                'first_name' => 'Amina',
                'last_name' => 'Said',
                'email' => 'amina.said@example.com',
                'phone' => '+255741852963',
                'password' => Hash::make('password'),
                'gender' => 'female',
                'date_of_birth' => '1996-02-14',
                'region' => 'Zanzibar',
                'district' => 'Stone Town',
                'points' => 75,
            ],
        ];

        foreach ($fans as $fanData) {
            Fan::create($fanData);
        }
    }
}
