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
        Schema::create('fan_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fan_id')->constrained()->onDelete('cascade');
            $table->string('subject');
            $table->text('message');
            $table->enum('category', ['general', 'complaint', 'suggestion', 'technical', 'membership']);
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->text('admin_reply')->nullable();
            $table->foreignId('replied_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('replied_at')->nullable();
            $table->boolean('is_spam')->default(false);
            $table->string('ip_address')->nullable();
            $table->json('attachments')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['fan_id', 'status']);
            $table->index(['category', 'status']);
            $table->index(['priority', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fan_messages');
    }
};
