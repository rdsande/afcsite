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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->string('category')->default('general'); // general, breaking, latest, updates
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false); // for hero section
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->integer('views')->default(0);
            $table->timestamps();
            
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['is_published', 'published_at']);
            $table->index(['category', 'is_published']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
