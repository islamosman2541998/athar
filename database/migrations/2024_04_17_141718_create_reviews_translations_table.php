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
        Schema::create('reviews_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('type');
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->unique(['review_id', 'locale']);
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
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
        Schema::dropIfExists('reviews_translations');
    }
};
