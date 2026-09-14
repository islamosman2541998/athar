<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('promo_code_category', function (Blueprint $table) {
    $table->unsignedBigInteger('promo_code_id');
    $table->unsignedBigInteger('category_id');
    $table->timestamps();

    $table->primary(['promo_code_id','category_id']);
    $table->foreign('promo_code_id')->references('id')->on('promo_codes')->onDelete('cascade');
    $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo_code_category');
    }
};
