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
        if (Schema::hasTable('orders') && !Schema::hasColumn('orders', 'cookies')) {
            Schema::table('orders', fn (Blueprint $table) => $table->json('cookies')->nullable());
        }
        if (Schema::hasTable('orders') && !Schema::hasColumn('orders', 'unique_order_cookies')) {
            Schema::table('orders', fn (Blueprint $table) => $table->string('unique_order_cookies')->nullable());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $columns = array_values(array_filter(['cookies', 'unique_order_cookies'], fn ($column) => Schema::hasColumn('orders', $column)));
        if (Schema::hasTable('orders') && $columns) {
            Schema::table('orders', fn (Blueprint $table) => $table->dropColumn($columns));
        }
    }
};
