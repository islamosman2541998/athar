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
        Schema::create('whats_app_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('number')->nullable();
            $table->boolean('status')->default(0)->nullable();
            $table->boolean('feature')->nullable(0);
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
        Schema::dropIfExists('whats_app_contacts');
    }
};
