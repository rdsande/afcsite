<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fan;
use App\Models\PointTransaction;
use Carbon\Carbon;

class PointTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fans = Fan::all();
        
        foreach ($fans as $fan) {
            // Create welcome bonus transaction
            PointTransaction::create([
                'fan_id' => $fan->id,
                'points' => 10,
                'type' => 'bonus',
                'description' => 'Welcome bonus for joining AZAM FC fan community',
                'created_at' => $fan->created_at,
                'updated_at' => $fan->created_at,
            ]);
            
            // Create some login transactions (simulate past logins)
            for ($i = 1; $i <= 5; $i++) {
                PointTransaction::create([
                    'fan_id' => $fan->id,
                    'points' => 1,
                    'type' => 'login',
                    'description' => 'Daily login bonus',
                    'created_at' => Carbon::now()->subDays($i),
                    'updated_at' => Carbon::now()->subDays($i),
                ]);
            }
            
            // Create a couple of win transactions
            PointTransaction::create([
                'fan_id' => $fan->id,
                'points' => 5,
                'type' => 'win',
                'description' => 'AZAM FC victory: AZAM FC vs Simba SC',
                'metadata' => ['fixture_id' => 1, 'match_date' => '2024-01-15'],
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ]);
            
            PointTransaction::create([
                'fan_id' => $fan->id,
                'points' => 5,
                'type' => 'win',
                'description' => 'AZAM FC victory: Young Africans vs AZAM FC',
                'metadata' => ['fixture_id' => 2, 'match_date' => '2024-01-20'],
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ]);
            
            // Update fan's total points to match transactions
            $totalPoints = $fan->pointTransactions()->sum('points');
            $fan->update(['points' => $totalPoints]);
        }
    }
}
