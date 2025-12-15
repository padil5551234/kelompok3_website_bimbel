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
        Schema::create('materials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->uuid('tutor_id');
            $table->enum('type', ['video', 'document', 'link', 'youtube'])->default('document');
            $table->string('file_path')->nullable(); // For uploaded files
            $table->string('youtube_url')->nullable(); // For YouTube videos
            $table->string('external_link')->nullable(); // For external links
            $table->string('thumbnail_path')->nullable(); // Thumbnail image
            $table->integer('file_size')->nullable(); // File size in bytes
            $table->string('file_type')->nullable(); // MIME type
            $table->integer('views_count')->default(0);
            $table->integer('downloads_count')->default(0);
            $table->boolean('is_public')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->json('tags')->nullable(); // Tags for categorization
            $table->text('content')->nullable(); // Text content for articles
            $table->integer('duration_seconds')->nullable(); // For video materials
            $table->timestamps();

            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['tutor_id', 'type']);
            $table->index('is_public');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};