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
        if (Schema::hasTable('promo_codes') && !Schema::hasColumn('promo_codes', 'title')) {
            Schema::table('promo_codes', fn (Blueprint $table) => $table->string('title')->nullable());
        }
        if (Schema::hasTable('promo_codes') && !Schema::hasColumn('promo_codes', 'code')) {
            Schema::table('promo_codes', fn (Blueprint $table) => $table->string('code')->nullable());
        }
        if (Schema::hasTable('promo_codes') && !Schema::hasColumn('promo_codes', 'type')) {
            Schema::table('promo_codes', fn (Blueprint $table) => $table->boolean('type')->default(1)->comment('1 = ratio(%) , 0 = fixed value'));
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('promo_codes')) {
            return;
        }
        $columns = array_values(array_filter(['title', 'code', 'type'], fn ($column) => Schema::hasColumn('promo_codes', $column)));
        if ($columns) {
            Schema::table('promo_codes', fn (Blueprint $table) => $table->dropColumn($columns));
        }
    }
};
