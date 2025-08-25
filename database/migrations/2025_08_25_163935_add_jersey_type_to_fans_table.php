<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fans', function (Blueprint $table) {
            $table->enum('favorite_jersey_type', ['home', 'away', 'third'])->default('home')->after('favorite_jersey_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fans', function (Blueprint $table) {
            $table->dropColumn('favorite_jersey_type');
        });
    }
};
