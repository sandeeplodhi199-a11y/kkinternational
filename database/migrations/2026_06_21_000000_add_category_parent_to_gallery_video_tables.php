<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tbl_gallery') && !Schema::hasColumn('tbl_gallery', 'parent')) {
            Schema::table('tbl_gallery', function (Blueprint $table) {
                $table->string('parent')->nullable()->after('name');
            });
        }

        if (Schema::hasTable('tbl_video') && !Schema::hasColumn('tbl_video', 'parent')) {
            Schema::table('tbl_video', function (Blueprint $table) {
                $table->string('parent')->nullable()->after('name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tbl_gallery') && Schema::hasColumn('tbl_gallery', 'parent')) {
            Schema::table('tbl_gallery', function (Blueprint $table) {
                $table->dropColumn('parent');
            });
        }

        if (Schema::hasTable('tbl_video') && Schema::hasColumn('tbl_video', 'parent')) {
            Schema::table('tbl_video', function (Blueprint $table) {
                $table->dropColumn('parent');
            });
        }
    }
};
