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
        Schema::create('gallery_groups_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gallery_group_id'); // Foreign key reference to the service_categories table
            $table->string('locale'); // Locale column (e.g., 'en', 'fr')
            $table->string('title')->nullable(); // Title column
            $table->string('slug')->nullable(); // Slug column
//            $table->string('description')->nullable(); // Description column
            $table->string('meta_title')->nullable(); // Meta title column
            $table->string('meta_desc')->nullable(); // Meta description column
            $table->string('meta_key')->nullable(); // Meta keywords column

            $table->timestamps(); // Adds 'created_at' and 'updated_at' columns

            // Define foreign key constraint
            $table->foreign('gallery_group_id')->references('id')->on('gallery_groups')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
