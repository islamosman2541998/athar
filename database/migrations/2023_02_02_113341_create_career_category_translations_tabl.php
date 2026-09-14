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
        Schema::create('career_category_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('career_category_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->unique(['career_category_id', 'locale']);
            $table->foreign('career_category_id')->references('id')->on('career_categories')->onDelete('cascade');
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
        Schema::dropIfExists('career_category_translations');
    }
};
