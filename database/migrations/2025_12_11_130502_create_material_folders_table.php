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
        Schema::create('material_folders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('batch_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('order_number')->default(0);
            $table->uuid('tutor_id')->nullable();
            $table->boolean('is_published')->default(true);
            $table->integer('meeting_number')->nullable();
            $table->string('meeting_title')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
            
            $table->foreign('batch_id')->references('id')->on('paket_ujian')->onDelete('cascade');
            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_folders');
    }
};
