<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoFieldsToServiceCategoryTranslationsTable extends Migration
{
    public function up()
    {
        Schema::table('service_category_translations', function (Blueprint $table) {
            $table->string('info_title')->nullable();
            $table->text('info_description')->nullable();
        });
    }

    public function down()
    {
        Schema::table('service_category_translations', function (Blueprint $table) {
            $table->dropColumn(['info_title', 'info_description']);
        });
    }
}
