<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceCategoryFollowingTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('service_category_following_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_category_following_id');
            $table->string('locale');
            $table->string('title');
            $table->text('description');
            $table->timestamps();

            $table->foreign('service_category_following_id', 'scft_following_id_fk')->references('id')
                ->on('service_category_followings')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_category_following_translations');
    }
}
