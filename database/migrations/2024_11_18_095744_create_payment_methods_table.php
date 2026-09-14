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
        //delete payment methods if it is existsts first in server
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('unique_name')->nullable()->unique();
            $table->string('qr_image')->nullable();
            $table->string('logo')->nullable();
            $table->enum('status', ['active', 'inactive'])->nullable();  // Use enum for status with possible values
            $table->decimal('minimum_price', 8, 2)->nullable();  // Adjust precision as needed
            $table->string('number')->nullable();
            $table->string('user_name')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null'); // Foreign key to users table

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
        Schema::dropIfExists('payment_methods');
    }
};
