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
     Schema::create('tbl_blog', function (Blueprint $table) {
        $table->id();
        $table->string('name')->nullable();
        $table->string('slug')->unique();
        $table->enum('status', ['Active', 'Inactive'])->nullable(); 
        $table->boolean('is_deleted')->default(false);
        $table->string('image')->nullable();
        $table->timestamp('add_date')->nullable();
        $table->unsignedBigInteger('add_id')->nullable();
        $table->text('short_content')->nullable();
        $table->longText('content')->nullable();
        $table->string('meta_title')->nullable();
        $table->string('meta_keywords')->nullable();
        $table->text('meta_description')->nullable();
        $table->timestamps();
    });

    

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_blog');
    }
};
