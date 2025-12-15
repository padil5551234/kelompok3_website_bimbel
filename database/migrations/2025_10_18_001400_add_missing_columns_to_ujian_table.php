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
        Schema::table('ujian', function (Blueprint $table) {
            // Add waktu_pengumuman column after waktu_akhir
            $table->dateTime('waktu_pengumuman')->nullable()->after('waktu_akhir');
            
            // Add random_pilihan column after random
            $table->tinyInteger('random_pilihan')->default(0)->comment('0. tidak, 1. ya')->after('random');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ujian', function (Blueprint $table) {
            $table->dropColumn(['waktu_pengumuman', 'random_pilihan']);
        });
    }
};