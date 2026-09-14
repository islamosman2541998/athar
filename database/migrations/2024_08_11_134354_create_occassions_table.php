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
        Schema::create('occassions', function (Blueprint $table) {
            $table->id();
//            $table->string('name'); // For storing the name, varchar equivalent
            $table->tinyInteger('type')->nullable(); // For storing the type, tiny int equivalent

            $table->tinyInteger('status')->nullable(); // For storing the type, tiny int equivalent
            $table->tinyInteger('featured')->nullable(); // For storing the type, tiny int equivalent
            $table->integer('sort')->nullable(); // For storing the type, tiny int equivalent
            $table->string('image')->nullable(); // For storing the type, tiny int equivalent



//            $table->unsignedBigInteger('updated_by'); // Foreign key to the products table
//            $table->unsignedBigInteger('created_by'); // Foreign key to the products table



            $table->unsignedBigInteger('updated_by')->nullable(); // Foreign key to gallery_groups table, nullable

            // Define foreign key constraint
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null'); // If the gallery_group is deleted, set this column to NULL


            $table->unsignedBigInteger('created_by')->nullable(); // Foreign key to gallery_groups table, nullable

            // Define foreign key constraint
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null'); // If the gallery_group is deleted, set this column to NULL


            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('occassions');
    }
};
