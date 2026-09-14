<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToGalleryImagesTable extends Migration
{
    public function up()
    {
        Schema::table('gallery_images', function (Blueprint $table) {
            $table->string('type')->default('image')->after('image');
        });
    }

    public function down()
    {
        Schema::table('gallery_images', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}