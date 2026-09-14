<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('blog_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title');
            $table->text('description');
            $table->unique(['blog_id','locale']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_translations');
    }
}