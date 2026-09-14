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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specialty_id');
            $table->string('image')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('degree')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->integer('sort')->nullable()->default(0);
            $table->tinyinteger('status')->nullable()->default(1);
            $table->tinyinteger('feature')->nullable()->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();        

            $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('cascade');
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
        Schema::dropIfExists('doctors');
    }
};
