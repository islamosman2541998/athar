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
    Schema::create('job_translations', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('job_id')->index();
        $table->string('locale')->index();

        $table->string('title')->nullable();
        $table->string('short_description')->nullable();
        $table->longText('description')->nullable();
        $table->longText('requirements')->nullable();
        $table->string('seo_title')->nullable();
        $table->text('seo_description')->nullable();

        $table->unique(['job_id', 'locale']);
        $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_translations');
    }
};
