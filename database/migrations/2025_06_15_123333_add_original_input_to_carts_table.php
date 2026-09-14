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
    Schema::table('carts', function (Blueprint $table) {
        $table->text('original_input')->nullable()->after('user_input');
    });
}

public function down()
{
    Schema::table('carts', function (Blueprint $table) {
        $table->dropColumn('original_input');
    });
}
};
