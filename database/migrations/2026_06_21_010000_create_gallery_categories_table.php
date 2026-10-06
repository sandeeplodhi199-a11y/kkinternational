<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tbl_gallery_category')) {
            Schema::create('tbl_gallery_category', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('status')->default('Active');
                $table->tinyInteger('is_deleted')->default(0);
                $table->timestamps();
            });
        }

        if (Schema::hasTable('tbl_gallery') && !Schema::hasColumn('tbl_gallery', 'category_id')) {
            Schema::table('tbl_gallery', function (Blueprint $table) {
                $table->unsignedBigInteger('category_id')->nullable()->after('parent');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tbl_gallery') && Schema::hasColumn('tbl_gallery', 'category_id')) {
            Schema::table('tbl_gallery', function (Blueprint $table) {
                $table->dropColumn('category_id');
            });
        }

        Schema::dropIfExists('tbl_gallery_category');
    }
};
