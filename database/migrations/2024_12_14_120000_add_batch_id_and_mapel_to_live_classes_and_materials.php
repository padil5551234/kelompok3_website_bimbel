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
        // Add batch_id to live_classes table if not exists
        if (!Schema::hasColumn('live_classes', 'batch_id')) {
            Schema::table('live_classes', function (Blueprint $table) {
                $table->uuid('batch_id')->nullable()->after('id');
                $table->foreign('batch_id')->references('id')->on('paket_ujian')->onDelete('cascade');
            });
        }

        // Add batch_id and mapel to materials table if not exists
        if (!Schema::hasColumn('materials', 'batch_id')) {
            Schema::table('materials', function (Blueprint $table) {
                $table->uuid('batch_id')->nullable()->after('id');
                $table->foreign('batch_id')->references('id')->on('paket_ujian')->onDelete('cascade');
            });
        }

        if (!Schema::hasColumn('materials', 'mapel')) {
            Schema::table('materials', function (Blueprint $table) {
                $table->string('mapel', 100)->nullable()->after('title');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('live_classes', function (Blueprint $table) {
            if (Schema::hasColumn('live_classes', 'batch_id')) {
                $table->dropForeign(['batch_id']);
                $table->dropColumn('batch_id');
            }
        });

        Schema::table('materials', function (Blueprint $table) {
            if (Schema::hasColumn('materials', 'batch_id')) {
                $table->dropForeign(['batch_id']);
                $table->dropColumn('batch_id');
            }
            if (Schema::hasColumn('materials', 'mapel')) {
                $table->dropColumn('mapel');
            }
        });
    }
};