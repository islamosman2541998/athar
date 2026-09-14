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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
//            $table->string('title'); // For storing the title, not nullable
            $table->string('image')->nullable(); // For storing the image path or URL, nullable
            $table->integer('sort')->nullable(); // For sorting or ordering, nullable
            // $table->tinyInteger('feature')->nullable(); // For storing feature status, nullable
            $table->tinyInteger('status')->nullable(); // For storing status, nullable
            $table->unsignedBigInteger('created_by')->nullable(); // Nullable foreign key
            $table->unsignedBigInteger('updated_by')->nullable(); // Nullable foreign key
            $table->boolean('show_in_cart')->default(0)->nullable(); // Meta keywords column
            $table->boolean('feature')->default(false)->index();



            $table->unsignedBigInteger('gallery_id')->nullable(); // Foreign key to gallery_groups table, nullable

            // Define foreign key constraint
            $table->foreign('gallery_id')
                ->references('id')
                ->on('gallery_groups')
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
        Schema::dropIfExists('product_categories');
    }
};
