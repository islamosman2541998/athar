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
        Schema::create('whats_app_contact_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('whats_app_contact_id'); // Foreign key reference to the service_categories table
            $table->string('locale'); // Locale column (e.g., 'en', 'fr')
            $table->string('title')->nullable(); // Title column
            $table->string('slug')->nullable(); // Slug column
            $table->string('meta_title')->nullable(); // Meta title column
            $table->string('meta_desc')->nullable(); // Meta description column
            $table->string('meta_key')->nullable(); // Meta keywords column



            // Define foreign key constraint
            $table->foreign('whats_app_contact_id')->references('id')->on('whats_app_contacts')->onDelete('cascade');

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
        Schema::dropIfExists('whats_app_contact_translations');
    }
};
