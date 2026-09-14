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
    Schema::table('product_pockets', function (Blueprint $table) {
        $table->string('image')->nullable()->after('price');
    });
}

public function down()
{
    Schema::table('product_pockets', function (Blueprint $table) {
        $table->dropColumn('image');
    });
}
};
