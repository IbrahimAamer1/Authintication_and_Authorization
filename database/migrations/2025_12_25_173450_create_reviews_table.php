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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->integer('rating')->comment('Rating from 1 to 5');
            $table->text('comment')->nullable();
            $table->boolean('is_approved')->default(true)->comment('For future moderation');
            $table->timestamps();

            // Unique constraint: one review per user per course
            $table->unique(['user_id', 'course_id']);

            // Indexes
            $table->index('user_id');
            $table->index('course_id');
            $table->index('rating');
            $table->index('is_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
