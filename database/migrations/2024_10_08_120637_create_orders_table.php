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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->nullable(); // varchar
            $table->string('customer_name')->nullable(); // varchar
            $table->string('customer_mobile')->nullable(); // varchar
            $table->string('customer_email')->nullable(); // varchar
            $table->double('total_quantity')->nullable(); // double
            $table->unsignedBigInteger('payment_method_id')->nullable(); // bigint
            $table->string('status')->nullable()->default(0); // tinyint
            $table->string('shipped_status')->nullable()->default(0); // tinyint
            $table->double('shipped_price')->nullable()->default(0); // double
            $table->double('total')->nullable()->default(0); // double
            $table->string('image')->nullable()->comment('image of the payment operation like the image of payment in insta pay or in vodafone cash');
            $table->unsignedBigInteger('created_by')->nullable(); // bigint
            $table->unsignedBigInteger('updated_by')->nullable(); // bigint
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
        Schema::dropIfExists('orders');
    }
};
