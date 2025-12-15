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
        // Add new columns for kode provinsi and kabupaten
        Schema::table('users_detail', function (Blueprint $table) {
            $table->string('kode_provinsi', 10)->nullable()->after('no_hp');
            $table->string('kode_kabupaten', 10)->nullable()->after('kode_provinsi');
        });

        // Create indexes for better performance
        Schema::table('users_detail', function (Blueprint $table) {
            $table->index('kode_provinsi');
            $table->index('kode_kabupaten');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_detail', function (Blueprint $table) {
            $table->dropIndex(['kode_provinsi']);
            $table->dropIndex(['kode_kabupaten']);
            $table->dropColumn(['kode_provinsi', 'kode_kabupaten']);
        });
    }
};