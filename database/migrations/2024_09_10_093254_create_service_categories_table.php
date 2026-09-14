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
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->integer('sort');
            $table->tinyInteger('feature');
            $table->tinyInteger('status');

            $table->unsignedBigInteger('page_id')->nullable();
            $table->unsignedBigInteger('gallery_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable(); // Nullable foreign key
            $table->unsignedBigInteger('updated_by')->nullable(); // Nullable foreign key

            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('set null')->onUpdate('cascade');        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_categories', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['page_id']);
            $table->dropForeign(['gallery_id']);
        });

        Schema::dropIfExists('service_categories');
    }
};
