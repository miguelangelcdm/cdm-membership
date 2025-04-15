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
        // Create memberships table first
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Example: Basic, Premium, VIP
            $table->decimal('price', 10, 2); // Price of membership
            $table->integer('duration')->comment('Duration in days'); // Example: 30 for a monthly membership
            $table->timestamps();
        });

        // Create user_memberships table after memberships table
        Schema::create('user_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('membership_id')->constrained('memberships')->onDelete('cascade');
            $table->dateTime('starts_at');
            $table->dateTime('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_memberships');
        Schema::dropIfExists('memberships');
    }
};