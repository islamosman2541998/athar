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
        Schema::create('occassions_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('occassion_id'); // Foreign key to the products table
            $table->string('locale'); // For storing the locale/language
            $table->string('title'); // For storing the product title in the given locale
            $table->text('description'  )->nullable(); // For storing the product slug in the given locale
            $table->timestamps(); // Creates `created_at` and `updated_at` columns

            // Define foreign key constraints
            $table->foreign('occassion_id')
                ->references('id')
                ->on('occassions')
                ->onDelete('cascade'); // Ensures that deleting a product also deletes its translations

            // Optionally, add a unique constraint to ensure unique translations per product and locale
            $table->unique(['occassion_id', 'locale']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('occassions_translations', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['occassion_id']);
        });

        Schema::dropIfExists('occassions_translations');    }
};
