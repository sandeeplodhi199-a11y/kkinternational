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
        Schema::create('tbl_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->enum('status', ['Active', 'Inactive'])->nullable();
            $table->text('content')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('orders_by', 255)->nullable();
            $table->string('add_id', 255)->nullable();
            $table->string('updated_id', 255)->nullable();
            $table->string('id_hash', 255)->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_attributes');
    }
};
