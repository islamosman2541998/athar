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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable(); // For storing the image path or URL, nullable
            $table->double('price', 14, 2)->nullable(); // For storing the price, nullable
            $table->double('sale', 14, 2)->nullable(); // For storing the sale price, nullable
            $table->double('price_after_sale', 14, 2)->nullable(); // For storing the price, nullable
            $table->boolean('show_in_cart')->default(0)->nullable(); // Meta keywords column
            $table->string('code')->nullable(); // For storing a product code, nullable
            $table->integer('sort')->nullable(); // For sorting or ordering, nullable
            $table->tinyInteger('feature')->nullable(); // For storing feature status, nullable
            $table->tinyInteger('status')->nullable(); // For storing status, nullable
            $table->unsignedBigInteger('created_by')->nullable(); // Foreign key to users who created the product, nullable
            $table->unsignedBigInteger('updated_by')->nullable(); // Foreign key to users who last updated the product, nullable
            $table->timestamps(); // Creates `created_at` and `updated_at` columns
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('product_category_id')->nullable(); // Foreign key to users who created the product, nullable
            // Define foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
