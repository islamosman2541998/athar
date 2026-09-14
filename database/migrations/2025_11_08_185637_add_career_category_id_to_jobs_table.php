<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCareerCategoryIdToJobsTable extends Migration
{
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
           
            $table->unsignedBigInteger('career_category_id')->nullable()->after('sort');

            $table->foreign('career_category_id')
                  ->references('id')->on('career_categories')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            if (Schema::hasColumn('jobs', 'career_category_id')) {
                $table->dropForeign(['career_category_id']);
                $table->dropColumn('career_category_id');
            }
        });
    }
}
