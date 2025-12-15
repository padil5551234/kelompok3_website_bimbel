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
        Schema::create('bank_soal', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('batch_id'); // id_paket as batch
            $table->uuid('tentor_id');
            $table->string('nama_banksoal');
            $table->text('deskripsi')->nullable();
            $table->string('mapel');
            $table->string('file_banksoal')->nullable();
            $table->date('tanggal_upload');
            $table->timestamps();

            $table->foreign('batch_id')->references('id')->on('paket_ujian')->onDelete('cascade');
            $table->foreign('tentor_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['batch_id', 'mapel']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_soal');
    }
};