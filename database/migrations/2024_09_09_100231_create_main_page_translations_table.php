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
        Schema::create('main_pages_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_page_id'); // Foreign key to the products table
            $table->string('company_name');

            $table->string('locale'); // For storing the locale/language
            $table->string('main_title');
            $table->text('main_desc');
            $table->string('services_title');
            $table->text('our_mission_desc');
            $table->string('happiness_title');
            $table->string('organic_title');
            $table->string('freshness_title');
            $table->string('delivery');
            $table->string('main_last_title');
            $table->text('main_last_desc');
            $table->string('address');

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
        Schema::dropIfExists('main_pages_translations');
    }
};
