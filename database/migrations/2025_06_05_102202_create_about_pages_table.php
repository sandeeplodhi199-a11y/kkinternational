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
        Schema::create('tbl_about_page', function (Blueprint $table) {
            $table->id();

            $table->string('about1')->nullable();
            $table->string('about2')->nullable();
            $table->string('about3')->nullable();
            $table->string('about4')->nullable();
            $table->string('about5')->nullable();
            $table->string('about6')->nullable();
            $table->string('about7')->nullable();
            $table->string('about8')->nullable();
            $table->string('about9')->nullable();
            $table->string('about10')->nullable();
            $table->string('about11')->nullable();
            $table->string('about12')->nullable();
            $table->string('about13')->nullable();
            $table->string('about14')->nullable();
            $table->string('about15')->nullable();
            $table->string('about16')->nullable();
            $table->string('about17')->nullable();
            $table->string('about18')->nullable();
            $table->string('about19')->nullable();
            $table->string('about20')->nullable();
            $table->string('about21')->nullable();
            $table->string('about22')->nullable();
            $table->string('about23')->nullable();
            $table->string('about24')->nullable();
            $table->string('about25')->nullable();
            $table->string('about26')->nullable();
            $table->string('about27')->nullable();
            $table->string('about28')->nullable();
            $table->string('about29')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_about_page');
    }
};
