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
            $table->boolean('allow_pembahasan_during_test')->default(false)->after('tampil_kunci');
            $table->integer('pembahasan_access_limit')->nullable()->after('allow_pembahasan_during_test');
            $table->text('pembahasan_access_reason')->nullable()->after('pembahasan_access_limit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ujian', function (Blueprint $table) {
            $table->dropColumn('allow_pembahasan_during_test');
            $table->dropColumn('pembahasan_access_limit');
            $table->dropColumn('pembahasan_access_reason');
        });
    }
};