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
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // Foreign key to the products table
            $table->string('locale'); // For storing the locale/language
            $table->string('title'); // For storing the product title in the given locale
            $table->string('slug'); // For storing the product slug in the given locale
            $table->text('description')->nullable(); // For storing the product description, nullable
            $table->string('meta_title')->nullable(); // For storing the meta title, nullable
            $table->string('meta_desc')->nullable(); // For storing the meta description, nullable
            $table->string('meta_key')->nullable(); // For storing the meta keywords, nullable
            $table->timestamps(); // Creates `created_at` and `updated_at` columns

            // Define foreign key constraints
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade'); // Ensures that deleting a product also deletes its translations

            // Optionally, add a unique constraint to ensure unique translations per product and locale
            $table->unique(['product_id', 'locale']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_translations', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['product_id']);
        });

        Schema::dropIfExists('product_translations');    }
};
