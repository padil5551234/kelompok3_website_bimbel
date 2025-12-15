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
        Schema::table('soal', function (Blueprint $table) {
            // Check if column exists before trying to drop it
            if (Schema::hasColumn('soal', 'id_kunci_jawaban')) {
                // Skip dropping foreign key for SQLite as it's not supported
                if (config('database.default') !== 'sqlite') {
                    $table->dropForeign('soal_id_kunci_jawaban_foreign');
                }
                $table->dropColumn('id_kunci_jawaban');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            //
        });
    }
};
