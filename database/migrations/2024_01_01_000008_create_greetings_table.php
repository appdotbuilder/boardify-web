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
        Schema::create('greetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('template_id')->constrained('greeting_templates')->onDelete('cascade');
            $table->text('custom_message');
            $table->string('sender_name');
            $table->enum('display_duration', [3, 5, 7])->default(5)->comment('Display duration in seconds');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'cancelled'])->default('pending');
            $table->string('payment_id')->nullable()->comment('Midtrans payment ID');
            $table->json('payment_details')->nullable()->comment('Midtrans payment response');
            $table->boolean('is_displayed')->default(false)->comment('Whether greeting has been shown in slideshow');
            $table->datetime('displayed_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index('event_id');
            $table->index('customer_id');
            $table->index('payment_status');
            $table->index(['event_id', 'payment_status']);
            $table->index(['event_id', 'is_displayed']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('greetings');
    }
};