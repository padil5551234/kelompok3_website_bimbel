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
            $table->bigInteger('kunci_jawaban')->unsigned()->nullable()->after('jenis_soal');
            $table->smallInteger('poin_benar')->default(0)->after('kunci_jawaban');
            $table->smallInteger('poin_salah')->default(0)->after('poin_benar');
            $table->foreign('kunci_jawaban')->references('id')->on('jawaban')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soal', function (Blueprint $table) {
            if (\Illuminate\Support\Facades\Schema::hasColumn('soal', 'kunci_jawaban')) {
                // Drop FK when not using SQLite to avoid errors
                if (config('database.default') !== 'sqlite') {
                    $table->dropForeign(['kunci_jawaban']);
                }
                $table->dropColumn(['kunci_jawaban', 'poin_benar', 'poin_salah']);
            }
        });
    }
};
