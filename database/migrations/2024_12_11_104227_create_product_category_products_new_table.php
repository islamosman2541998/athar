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
        Schema::create('product_category_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('SET NULL')->onUpdate('SET NULL');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('SET NULL')->onUpdate('SET NULL');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_category_products');
    }
};
