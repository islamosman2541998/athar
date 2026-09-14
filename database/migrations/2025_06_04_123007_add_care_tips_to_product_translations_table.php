<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCareTipsToProductTranslationsTable extends Migration
{
    public function up()
    {
        Schema::table('product_translations', function (Blueprint $table) {
            $table->text('care_tips')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('product_translations', function (Blueprint $table) {
            $table->dropColumn('care_tips');
        });
    }
}