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
        Schema::create('products_occassions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('occassion_id'); // Foreign key to the occassions table
            $table->unsignedBigInteger('product_id'); // Foreign key to the products table

            // Define foreign key constraints
            $table->foreign('occassion_id')->references('id')->on('occassions')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Optional: Add a unique constraint to ensure the combination of occassion_id and product_id is unique
            $table->unique(['occassion_id', 'product_id']);
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
        Schema::dropIfExists('products_occassions');
    }
};
