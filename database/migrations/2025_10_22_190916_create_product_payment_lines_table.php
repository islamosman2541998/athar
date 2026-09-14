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
        Schema::create('product_payment_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); 
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->text('links')->nullable();
            $table->string('color')->nullable();
            $table->integer('sort')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_payment_lines');
    }
};
