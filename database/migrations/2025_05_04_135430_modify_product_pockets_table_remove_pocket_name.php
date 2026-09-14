<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProductPocketsTableRemovePocketName extends Migration
{
    public function up()
    {
        Schema::table('product_pockets', function (Blueprint $table) {
            $table->dropColumn('pocket_name');
        });
    }

    public function down()
    {
        Schema::table('product_pockets', function (Blueprint $table) {
            $table->string('pocket_name')->after('product_id');
        });
    }
}