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
        if (Schema::hasTable('delivery_details')) {
            return;
        }

        Schema::create('delivery_details', function (Blueprint $table) {
            $table->id();
            $table->string('st_name', 100)->nullable();
            $table->string('apartment', 100)->nullable();
            $table->string('floor', 100)->nullable();
            $table->string('area', 100)->nullable();
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null'); // Foreign key to users table
            $table->float('shipping_cost', 14, 2)->nullable();
            $table->float('total', 14, 2)->nullable();
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->onDelete('set null')->default(1); // Foreign key to users table
            $table->tinyInteger('status')->nullable();

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
        Schema::dropIfExists('delivery_details');
    }
};
