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
        Schema::create('admin_notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('type', ['info', 'success', 'warning', 'danger'])->default('info');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_dismissible')->default(true);
            $table->boolean('show_on_dashboard')->default(true);
            $table->boolean('show_on_login')->default(false);
            $table->datetime('starts_at')->nullable();
            $table->datetime('expires_at')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->json('target_audience')->nullable(); // For future targeting specific fan groups
            $table->integer('view_count')->default(0);
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            
            // Indexes for performance
            $table->index(['is_active', 'starts_at', 'expires_at']);
            $table->index(['type', 'priority']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notices');
    }
};
