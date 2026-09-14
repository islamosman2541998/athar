<?php

namespace App\Support;

use App\Settings\SettingSingleton;

/**
 * Selectable fonts for the site and dashboard (stored in the "font_setting" settings group).
 */
class FontOptions
{
    public const ARABIC = [
        'cairo' => ['label' => 'Cairo', 'family' => 'Cairo', 'google' => 'Cairo:wght@400;500;600;700;800;900'],
        'tajawal' => ['label' => 'Tajawal', 'family' => 'Tajawal', 'google' => 'Tajawal:wght@400;500;700;800;900'],
        'almarai' => ['label' => 'Almarai', 'family' => 'Almarai', 'google' => 'Almarai:wght@400;700;800'],
    ];

    public const ENGLISH = [
        'poppins' => ['label' => 'Poppins', 'family' => 'Poppins', 'google' => 'Poppins:wght@400;500;600;700;800;900'],
        'inter' => ['label' => 'Inter', 'family' => 'Inter', 'google' => 'Inter:wght@400;500;600;700;800;900'],
        'montserrat' => ['label' => 'Montserrat', 'family' => 'Montserrat', 'google' => 'Montserrat:wght@400;500;600;700;800;900'],
    ];

    public const DEFAULT_ARABIC = 'cairo';
    public const DEFAULT_ENGLISH = 'poppins';

    public static function selected(): array
    {
        $values = SettingSingleton::getInstance()->getFontSetting();

        $arabic = $values?->firstWhere('key', 'font_ar')?->value;
        $english = $values?->firstWhere('key', 'font_en')?->value;

        return [
            'ar' => self::ARABIC[$arabic] ?? self::ARABIC[self::DEFAULT_ARABIC],
            'en' => self::ENGLISH[$english] ?? self::ENGLISH[self::DEFAULT_ENGLISH],
        ];
    }

    /**
     * Google Fonts stylesheet URL for both selected fonts.
     */
    public static function stylesheetUrl(array $selected): string
    {
        $families = collect($selected)->pluck('google')->map(fn ($family) => 'family=' . str_replace(' ', '+', $family));

        return 'https://fonts.googleapis.com/css2?' . $families->implode('&') . '&display=swap';
    }

    /**
     * CSS font stack: the current locale's font first, then the other language's font as a fallback.
     */
    public static function stack(array $selected, ?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $primary = $locale === 'ar' ? $selected['ar'] : $selected['en'];
        $secondary = $locale === 'ar' ? $selected['en'] : $selected['ar'];

        return "'{$primary['family']}', '{$secondary['family']}', 'Segoe UI', Tahoma, Arial, sans-serif";
    }
}
