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
    Schema::create('filter_translations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('filter_id')->constrained()->cascadeOnDelete();
        $table->string('locale')->index();
        $table->string('name');
        $table->string('slug')->nullable();
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
        Schema::dropIfExists('filter_translations');
    }
};