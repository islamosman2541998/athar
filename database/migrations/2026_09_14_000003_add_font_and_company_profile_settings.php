<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        // Company profile PDF (type 6 = PDF upload in the site settings form).
        $siteSettingId = DB::table('settings')->where('key', 'site_setting')->value('id');
        if ($siteSettingId && !DB::table('settings_values')->where('key', 'company_profile')->exists()) {
            DB::table('settings_values')->insert([
                'setting_id' => $siteSettingId,
                'key' => 'company_profile',
                'value' => null,
                'type' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Font settings group.
        $fontSettingId = DB::table('settings')->where('key', 'font_setting')->value('id')
            ?? DB::table('settings')->insertGetId(['key' => 'font_setting', 'status' => 1, 'created_at' => $now, 'updated_at' => $now]);

        foreach (['font_ar' => 'cairo', 'font_en' => 'poppins'] as $key => $value) {
            if (!DB::table('settings_values')->where('setting_id', $fontSettingId)->where('key', $key)->exists()) {
                DB::table('settings_values')->insert([
                    'setting_id' => $fontSettingId,
                    'key' => $key,
                    'value' => $value,
                    'type' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        $fontSettingId = DB::table('settings')->where('key', 'font_setting')->value('id');
        if ($fontSettingId) {
            DB::table('settings_values')->where('setting_id', $fontSettingId)->delete();
            DB::table('settings')->where('id', $fontSettingId)->delete();
        }

        DB::table('settings_values')->where('key', 'company_profile')->delete();
    }
};
