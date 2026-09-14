<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoreValuesToAboutTranslationsTable extends Migration
{
    public function up()
    {
        Schema::table('about_translations', function (Blueprint $table) {
            $table->json('core_values')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('about_translations', function (Blueprint $table) {
            $table->dropColumn('core_values');
        });
    }
}
