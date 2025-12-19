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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('video_file')->nullable();
            $table->integer('lesson_order')->default(0);
            $table->boolean('is_free')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            //indexes
            $table->index('course_id');
            $table->index('slug');
            $table->index('is_published');
            $table->index('lesson_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
