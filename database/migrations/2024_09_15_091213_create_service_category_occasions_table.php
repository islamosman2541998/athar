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
        Schema::create('service_category_occasions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('occassion_id'); // Foreign key to the occassions table
            $table->unsignedBigInteger('category_service_id'); // Foreign key to the products table

            // Define foreign key constraints
            $table->foreign('occassion_id')->references('id')->on('occassions')->onDelete('cascade');
            $table->foreign('category_service_id')->references('id')->on('service_categories')->onDelete('cascade');

//            // Optional: Add a unique constraint to ensure the combination of occassion_id and product_id is unique
//            $table->unique(['occassion_id', 'category_service_id' , 'uniq_occassion_service']);

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
//        Schema::table('service_category_occasions', function (Blueprint $table) {
//            // Drop the unique constraint by the short name
//            $table->dropUnique('uniq_occassion_service');
//        });
        Schema::dropIfExists('service_category_occasions');
    }
};
