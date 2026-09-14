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
        if (Schema::hasTable('carts') && Schema::hasTable('cart_groups') && !Schema::hasColumn('carts', 'cart_group_id')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->foreignId('cart_group_id')->nullable()->constrained()->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('carts') && Schema::hasColumn('carts', 'cart_group_id')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->dropConstrainedForeignId('cart_group_id');
            });
        }
     }
};
