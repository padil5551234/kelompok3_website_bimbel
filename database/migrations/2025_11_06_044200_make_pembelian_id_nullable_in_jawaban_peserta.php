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
        Schema::table('jawaban_peserta', function (Blueprint $table) {
            // Make pembelian_id nullable since we're now using ujian_user_id
            $table->bigInteger('pembelian_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jawaban_peserta', function (Blueprint $table) {
            $table->bigInteger('pembelian_id')->unsigned()->nullable(false)->change();
        });
    }
};