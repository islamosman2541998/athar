<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPocketTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('product_pocket_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_pocket_id');
            $table->string('locale')->index();
            $table->string('pocket_name');
            $table->timestamps();

            $table->foreign('product_pocket_id')->references('id')->on('product_pockets')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_pocket_translations');
    }
}