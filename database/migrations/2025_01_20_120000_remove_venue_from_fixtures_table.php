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
        if (Schema::hasTable('fixtures') && Schema::hasColumn('fixtures', 'venue')) {
            Schema::table('fixtures', function (Blueprint $table) {
                $table->dropColumn('venue');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('fixtures') && !Schema::hasColumn('fixtures', 'venue')) {
            Schema::table('fixtures', function (Blueprint $table) {
                $table->string('venue')->after('match_date');
            });
        }
    }
};