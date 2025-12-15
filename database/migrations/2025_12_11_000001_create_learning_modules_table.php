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
        Schema::create('learning_modules', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul modul pembelajaran
            $table->string('subtitle')->nullable(); // Sub judul
            $table->text('description')->nullable(); // Deskripsi modul
            $table->enum('category', ['SKD', 'MATEMATIKA_TERANTUNG'])->nullable(); // Kategori: SKD atau MATEMATIKA TERANTUNG
            $table->string('subject')->nullable(); // Mata pelajaran (TIU, TKP, TKA, dll)
            $table->string('color')->default('#007bff'); // Warna tema untuk modul
            $table->string('icon')->nullable(); // Icon untuk modul
            $table->integer('order_number')->default(0); // Urutan tampilan
            $table->integer('estimated_duration')->nullable(); // Estimasi durasi belajar (menit)
            $table->integer('total_sections')->default(0); // Total section dalam modul
            $table->integer('total_lessons')->default(0); // Total materi/lesson dalam modul
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_free')->default(false); // Apakah gratis atau premium
            $table->json('learning_objectives')->nullable(); // Tujuan pembelajaran
            $table->json('prerequisites')->nullable(); // Syarat/prerequisite
            $table->string('thumbnail_path')->nullable(); // Path thumbnail
            $table->text('introduction_text')->nullable(); // Teks introduksi
            $table->string('intro_video_url')->nullable(); // URL video introduksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_modules');
    }
};