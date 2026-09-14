<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoImageToServiceCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('service_categories', function (Blueprint $table) {
            $table->string('info_image')->nullable()->after('image');
        });
    }

    public function down()
    {
        Schema::table('service_categories', function (Blueprint $table) {
            $table->dropColumn('info_image');
        });
    }
}
