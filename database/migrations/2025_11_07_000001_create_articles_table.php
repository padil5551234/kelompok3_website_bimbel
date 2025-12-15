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
        if (!Schema::hasTable('articles')) {
            Schema::create('articles', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('excerpt')->nullable();
                $table->text('content');
                $table->string('featured_image')->nullable();
                $table->string('category')->default('umum');
                $table->uuid('author_id')->nullable();
                $table->string('status')->default('draft');
                $table->boolean('is_featured')->default(false);
                $table->integer('views_count')->default(0);
                $table->json('tags')->nullable();
                $table->json('meta_keywords')->nullable();
                $table->text('meta_description')->nullable();
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
                $table->index('status');
                $table->index('category');
                $table->index('published_at');
                $table->index('is_featured');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};