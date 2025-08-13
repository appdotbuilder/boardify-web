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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('category', ['individual', 'building_owner'])->default('individual');
            $table->string('phone');
            $table->text('address');
            $table->string('location_name')->nullable()->comment('For building owners');
            $table->json('location_types')->nullable()->comment('Array of location types for building owners');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('user_id');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};