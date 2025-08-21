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
        Schema::create('fan_jerseys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fan_id')->constrained()->onDelete('cascade');
            $table->foreignId('jersey_id')->constrained()->onDelete('cascade');
            $table->string('custom_name')->nullable(); // Fan's name on jersey
            $table->integer('custom_number')->nullable(); // Fan's number on jersey
            $table->string('size'); // XS, S, M, L, XL, XXL
            $table->json('customizations'); // Additional customizations (colors, patches, etc.)
            $table->string('status')->default('pending'); // pending, processing, completed, shipped
            $table->decimal('total_price', 8, 2);
            $table->string('order_reference')->unique();
            $table->timestamp('ordered_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index(['fan_id', 'status']);
            $table->index('order_reference');
            $table->unique(['jersey_id', 'custom_number'], 'unique_jersey_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fan_jerseys');
    }
};
