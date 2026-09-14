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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Foreign key to users table, nullable
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null'); // Foreign key to products table, nullable
            $table->string('product_name')->nullable(); // Product name, nullable
            $table->string('cookeries')->nullable(); // Cookeries information, nullable
            $table->double('price' , 14 , 2)->nullable(); // Price of the product, nullable
            $table->double('total_price')->nullable(); // Price of the product, nullable
            $table->double('quantity')->nullable(); // Quantity of the product, nullable
            $table->double('total')->nullable(); // Total price (price * quantity), nullable

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
        Schema::dropIfExists('carts');
    }
};
