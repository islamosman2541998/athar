<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Video covers now come from a frame of the video itself, so the uploaded poster is unused.
        if (Schema::hasColumn('portfolios', 'poster')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->dropColumn('poster');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('portfolios', 'poster')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->string('poster')->nullable()->after('image');
            });
        }
    }
};
