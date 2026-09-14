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
        Schema::create('product_category_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_category_id'); // Foreign key to the products table
            $table->string('locale'); // For storing the locale/language
            $table->string('title'); // For storing the product title in the given locale
            $table->string('slug'); // For storing the product slug in the given locale
            $table->string('meta_title')->nullable(); // For storing the meta title, nullable
            $table->string('meta_desc')->nullable(); // For storing the meta description, nullable
            $table->string('meta_key')->nullable(); // For storing the meta keywords, nullable

            $table->text('description')->nullable(); // For storing the meta title, nullable

            // Define foreign key constraints
            $table->foreign('product_category_id')
                ->references('id')
                ->on('product_categories')
                ->onDelete('cascade'); // Ensures that deleting a product also deletes its translations

            // Optionally, add a unique constraint to ensure unique translations per product and locale
            $table->unique(['product_category_id', 'locale']);


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
        Schema::dropIfExists('product_category_translations');
    }
};
