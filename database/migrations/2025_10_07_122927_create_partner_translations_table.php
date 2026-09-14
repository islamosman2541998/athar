<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('partner_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id')->index();
            $table->string('locale')->index();

            $table->string('title')->nullable();

            $table->unique(['partner_id','locale']);
            $table->foreign('partner_id')
                  ->references('id')->on('partners')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('partner_translations');
    }
};
