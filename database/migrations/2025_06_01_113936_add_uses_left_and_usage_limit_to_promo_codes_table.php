<?php

// database/migrations/2025_06_xxxxxx_add_usage_limit_to_promo_codes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->unsignedInteger('usage_limit')->default(1)->after('status');
            $table->unsignedInteger('uses_left')->default(1)->after('usage_limit');
        });
    }

    public function down()
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->dropColumn(['usage_limit', 'uses_left']);
        });
    }
};

