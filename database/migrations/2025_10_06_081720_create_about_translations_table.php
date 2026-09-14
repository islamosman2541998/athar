<?php

// database/migrations/2025_01_01_000001_create_about_translations_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('about_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('about_id')->index();
            $table->string('locale')->index();

            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->text('sub_description')->nullable();

            $table->string('our_story_title')->nullable();
            $table->text('our_story_description')->nullable();

            $table->string('ceo_title')->nullable();
            $table->text('ceo_description')->nullable();

            $table->text('vision')->nullable();
            $table->text('mission')->nullable();

            $table->text('at_a_glance')->nullable(); 

            $table->timestamps();

            // foreign key
            $table->foreign('about_id')
                  ->references('id')->on('abouts')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_translations');
    }
}
