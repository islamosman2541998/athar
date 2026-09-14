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
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->integer('sort');
//            $table->string('title')->nullable();
//            $table->string('title_en')->nullable();

            $table->tinyInteger('feature')->default(0);

            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('gallery_group_id')->nullable(); // Nullable foreign key
            $table->unsignedBigInteger('created_by')->nullable(); // Nullable foreign key
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('gallery_group_id')
                ->references('id')
                ->on('gallery_groups')
                ->onDelete('set null'); // Optional: handle deletion of gallery groups

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gallery_images');
    }
};
