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
        Schema::create('tbl_membership', function (Blueprint $table) {
            $table->id();
            $table->string('plan_heading')->nullable();
            $table->string('validity_type')->nullable();
            $table->string('plan_validity')->nullable();
            $table->string('price')->nullable();
            $table->string('discount')->nullable();
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_membership');
    }
};
