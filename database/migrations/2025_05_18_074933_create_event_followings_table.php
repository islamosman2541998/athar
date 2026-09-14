<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventFollowingsTable extends Migration
{
    public function up()
    {
        Schema::create('event_followings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('service_categories')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_followings');
    }
}