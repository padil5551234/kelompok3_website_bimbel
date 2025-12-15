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
            // Add ujian_user_id column after pembelian_id
            $table->uuid('ujian_user_id')->nullable()->after('pembelian_id');
            
            // Add foreign key constraint
            $table->foreign('ujian_user_id')
                  ->references('id')
                  ->on('ujian_user')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jawaban_peserta', function (Blueprint $table) {
            $table->dropForeign(['ujian_user_id']);
            $table->dropColumn('ujian_user_id');
        });
    }
};