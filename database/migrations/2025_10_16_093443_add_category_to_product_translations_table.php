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
        Schema::table('product_translations', function (Blueprint $table) {
            $table->text('category')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('product_translations', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
