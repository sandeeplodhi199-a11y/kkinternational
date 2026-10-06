<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary Key
            $table->string('name', 255);
            $table->string('slug', 255)->nullable()->index(); 
            $table->enum('status', ['Active', 'Inactive'])->nullable();
            $table->text('content')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('orders_by', 255)->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_keywords', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical', 255)->nullable();
            $table->string('add_id', 255)->nullable();
            $table->string('updated_id', 255)->nullable();
            $table->string('id_hash', 255)->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
