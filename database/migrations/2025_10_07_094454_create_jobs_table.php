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
    Schema::create('jobs', function (Blueprint $table) {
        $table->id();
        $table->string('slug')->nullable()->index();
        $table->string('employment_type')->nullable(); 
        $table->string('location')->nullable(); 
        $table->string('image')->nullable(); 
        $table->boolean('status')->default(true);
        $table->integer('sort')->default(0);
        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('updated_by')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
