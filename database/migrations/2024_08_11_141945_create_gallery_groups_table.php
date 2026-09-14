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
        Schema::create('gallery_groups', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->nullable()->comment('0 -> products ,  1 -> product_categories , 2 -> service_categories , 3 ->  occasions ');
//            $table->string('title')->nullable();
//            $table->string('title_en')->nullable();

            $table->tinyInteger('status')->nullable();
            $table->unsignedBigInteger('foreign_key')->nullable();
            $table->unsignedBigInteger('created_by')->nullable(); // Use unsignedBigInteger for foreign key references
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null'); // Set to null if the referenced user is deleted

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
        Schema::dropIfExists('gallery_groups');
    }
};
