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
        if (Schema::hasTable('orders') && !Schema::hasColumn('orders', 'address')) {
            Schema::table('orders', fn (Blueprint $table) => $table->string('address', 500)->nullable());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'address')) {
            Schema::table('orders', fn (Blueprint $table) => $table->dropColumn('address'));
        }
    }
};
