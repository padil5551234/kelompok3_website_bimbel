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
        Schema::table('pembelian', function (Blueprint $table) {
            // Skip dropping foreign key for SQLite as it's not supported
            if (config('database.default') !== 'sqlite') {
                $table->dropForeign('pembelian_ujian_id_foreign');
            }
            $table->dropColumn('ujian_id');

            $table->uuid('paket_id')->after('id');
            $table->foreign('paket_id')->references('id')->on('paket_ujian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembelian', function (Blueprint $table) {
            // Skip dropping foreign key for SQLite as it's not supported
            if (config('database.default') !== 'sqlite') {
                $table->dropForeign('pembelian_paket_id_foreign');
            }
            $table->dropColumn('paket_id');

            $table->uuid('ujian_id')->after('id');
            $table->foreign('ujian_id')->references('id')->on('ujian')->onDelete('cascade');
        });
    }
};
