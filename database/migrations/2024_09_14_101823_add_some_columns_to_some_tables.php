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
        Schema::table('gallery_images', function (Blueprint $table) {
//            $table->string('title')->nullable();
            $table->string('title_en')->nullable();

        });

        Schema::table('gallery_groups', function (Blueprint $table) {
//            $table->string('title')->nullable();
            $table->string('title_en')->nullable();
        });

//        title
//        title_en

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropColumns('gallery_groups' ,[  'title_en' ]);
        Schema::dropColumns('gallery_images' ,[   'title_en']);

//        Schema::table('gallery_groups', function (Blueprint $table) {
//            $table->string('item_en')->nullable();
//        });

    }
};
