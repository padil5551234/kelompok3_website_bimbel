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
        Schema::create('learning_progress', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('paket_id')->nullable()->constrained('paket_ujian')->onDelete('cascade');
            $table->foreignUuid('material_id')->nullable()->constrained('materials')->onDelete('cascade');
            $table->foreignUuid('ujian_id')->nullable()->constrained('ujian')->onDelete('cascade');
            $table->enum('activity_type', ['material_view', 'material_complete', 'tryout_attempt', 'tryout_complete'])->default('material_view');
            $table->integer('duration_seconds')->default(0);
            $table->integer('progress_percentage')->default(0);
            $table->decimal('score', 5, 2)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('paket_id');
            $table->index('activity_type');
            $table->index('created_at');
        });

        // Table for daily study statistics
        Schema::create('study_statistics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->date('study_date');
            $table->integer('total_study_time')->default(0); // in seconds
            $table->integer('materials_viewed')->default(0);
            $table->integer('tryouts_completed')->default(0);
            $table->decimal('average_score', 5, 2)->nullable();
            $table->json('subjects_studied')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'study_date']);
            $table->index('study_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_statistics');
        Schema::dropIfExists('learning_progress');
    }
};