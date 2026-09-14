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
        Schema::create('category_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('level')->nullable()->default(1);
            $table->integer('sort')->nullable()->default(0);
            $table->tinyInteger('back_home')->nullable()->default(1);
            $table->tinyinteger('feature')->nullable()->default(1);
            $table->tinyInteger('status')->nullable()->default(1);

            $table->string('kafara')->nullable();
            $table->string('image')->nullable();
            $table->string('background_image')->nullable();
            $table->string('background_color')->nullable();
            $table->string('section_bg')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->softDeletes();
            $table->timestamps();
 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_projects');
    }
};
