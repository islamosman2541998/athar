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
        if (Schema::hasTable('orders') && Schema::hasTable('promo_codes') && !Schema::hasColumn('orders', 'promo_code_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('promo_code_id')->nullable()->constrained('promo_codes')->nullOnDelete();
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

        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'promo_code_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropConstrainedForeignId('promo_code_id');
            });
        }

    }
};
