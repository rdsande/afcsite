<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jersey;

class CheckJerseys extends Command
{
    protected $signature = 'check:jerseys';
    protected $description = 'Check jersey data in database';

    public function handle()
    {
        $jerseys = Jersey::all();
        
        $this->info('Total jerseys: ' . $jerseys->count());
        
        foreach ($jerseys as $jersey) {
            $this->line("ID: {$jersey->id}, Name: {$jersey->name}, Type: {$jersey->type}, Active: {$jersey->is_active}, Image: {$jersey->template_image}");
        }
        
        return 0;
    }
}
