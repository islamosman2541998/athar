<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventFollowingTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('event_following_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_following_id')->constrained('event_followings')->onDelete('cascade');
            $table->string('locale');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_following_translations');
    }
}