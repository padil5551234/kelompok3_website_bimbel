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
        Schema::table('paket_ujian', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('whatsapp_group_link')->comment('Status aktif/tidak aktif course');
            $table->string('kategori')->default('umum')->after('is_active')->comment('Kategori course (matematika, bahasa, etc)');
            $table->string('level')->default('beginner')->after('kategori')->comment('Level course (beginner, intermediate, advanced)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paket_ujian', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'kategori', 'level']);
        });
    }
};
