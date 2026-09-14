<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceCategoryFollowingsTable extends Migration
{
    public function up()
    {
        Schema::create('service_category_followings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_category_id');
            $table->string('image');
            $table->timestamps();

            $table->foreign('service_category_id')
                  ->references('id')
                  ->on('service_categories')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_category_followings');
    }
}