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
        Schema::table('blog_translations', function (Blueprint $table) {
            $table->string('slug')->nullable(); 
            $table->string('meta_title')->nullable(); 
            $table->string('meta_desc')->nullable(); 
            $table->string('meta_key')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_translations', function (Blueprint $table) {
            //
        });
    }
};
