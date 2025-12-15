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
        Schema::table('materials', function (Blueprint $table) {
            $table->integer('chapter_number')->nullable()->after('is_featured');
            $table->string('chapter_title')->nullable()->after('chapter_number');
            $table->integer('material_order')->default(0)->after('chapter_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['chapter_number', 'chapter_title', 'material_order']);
        });
    }
};
