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
        Schema::table('service_category_translations', function (Blueprint $table) {
            $table->string('middle_title')->nullable();
            $table->text('middle_content')->nullable();

            $table->unsignedBigInteger('gallery_id')->nullable(); // Foreign key to gallery_groups table, nullable

            // Define foreign key constraint
            $table->foreign('gallery_id')
                ->references('id')
                ->on('gallery_groups')
                ->onDelete('set null'); // If the gallery_group is deleted, set this column to NULL


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_category_translations', function (Blueprint $table) {
            Schema::dropColumns('service_category_translations' ,[  'middle_content' , 'middle_title' , 'gallery_id' ]);

        });
    }




};
