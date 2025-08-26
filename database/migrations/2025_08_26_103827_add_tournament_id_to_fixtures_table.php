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
        Schema::table('fixtures', function (Blueprint $table) {
            $table->foreignId('tournament_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->dropForeign(['tournament_id']);
            $table->dropColumn('tournament_id');
        });
    }
};
