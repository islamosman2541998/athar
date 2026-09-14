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
        if (Schema::hasTable('promo_codes_translations')) {
            return;
        }

        Schema::create('promo_codes_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promo_code_id');
            $table->string('locale');
            $table->string('title')->nullable();

            // Define foreign key constraint
            $table->foreign('promo_code_id')->references('id')->on('promo_codes')->onDelete('cascade');
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
        Schema::dropIfExists('promo_codes_translations');
    }
};
