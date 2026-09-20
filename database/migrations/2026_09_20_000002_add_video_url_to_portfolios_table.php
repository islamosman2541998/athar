<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('portfolios', 'video_url')) {
            Schema::table('portfolios', function (Blueprint $table) {
                // YouTube link used instead of uploading a video file.
                $table->string('video_url')->nullable()->after('image');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('portfolios', 'video_url')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->dropColumn('video_url');
            });
        }
    }
};
