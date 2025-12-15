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
        Schema::create('live_classes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->uuid('tutor_id');
            $table->string('meeting_link')->nullable();
            $table->string('meeting_password')->nullable();
            $table->enum('platform', ['zoom', 'google_meet', 'teams', 'other'])->default('zoom');
            $table->dateTime('scheduled_at');
            $table->integer('duration_minutes')->default(60);
            $table->integer('max_participants')->nullable();
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');
            $table->text('materials')->nullable(); // JSON field for materials
            $table->timestamps();

            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['tutor_id', 'scheduled_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_classes');
    }
};