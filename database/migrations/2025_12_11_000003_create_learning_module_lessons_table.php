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
        Schema::create('learning_module_lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->string('title'); // Judul lesson/materi
            $table->string('subtitle')->nullable(); // Sub judul
            $table->text('description')->nullable(); // Deskripsi lesson
            $table->integer('order_number')->default(0); // Urutan lesson dalam section
            $table->integer('estimated_duration')->nullable(); // Estimasi durasi (menit)
            $table->enum('lesson_type', ['video', 'text', 'quiz', 'exercise', 'document', 'interactive'])->default('text');
            $table->boolean('is_published')->default(false);
            $table->boolean('is_mandatory')->default(false); // Apakah wajib atau opsional
            $table->text('content')->nullable(); // Konten teks
            $table->string('video_url')->nullable(); // URL video
            $table->string('document_path')->nullable(); // Path dokumen
            $table->string('external_link')->nullable(); // Link eksternal
            $table->json('quiz_data')->nullable(); // Data quiz (jika lesson_type = quiz)
            $table->json('exercise_data')->nullable(); // Data latihan
            $table->json('interactive_data')->nullable(); // Data interaktif
            $table->text('notes')->nullable(); // Catatan tutor
            $table->string('thumbnail_path')->nullable(); // Path thumbnail
            $table->integer('views_count')->default(0); // Jumlah views
            $table->integer('completion_rate')->default(0); // Tingkat penyelesaian (%)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_module_lessons');
    }
};