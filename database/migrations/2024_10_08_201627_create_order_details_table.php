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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
//            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Foreign key to orders table
//            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Foreign key to products table
//            $table->string('product_name'); // Product name
//            $table->double('price'); // Original price
//            $table->double('sale')->nullable(); // Sale discount (optional)
//            $table->double('price_after_sale'); // Price after applying sale
//            $table->double('quantity'); // Quantity ordered
//            $table->double('total'); // Total amount for this order detail
//            $table->tinyInteger('refund_status')->default(0); // Refund status
//            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Foreign key to users table
//            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade'); // Foreign key to orders table, nullable
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade'); // Foreign key to products table, nullable
            $table->string('product_name'); // Product name
            $table->double('price'); // Original price
            $table->double('sale')->nullable()->default(0); // Sale discount (optional)
            $table->double('price_after_sale'); // Price after applying sale
            $table->double('quantity'); // Quantity ordered
            $table->double('total'); // Total amount for this order detail
            $table->tinyInteger('refund_status')->default(0)->nullable(); // Refund status
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade'); // Foreign key to users table, nullable
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade'); // Foreign key to users table, nullable

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
        Schema::dropIfExists('order_details');
    }
};
