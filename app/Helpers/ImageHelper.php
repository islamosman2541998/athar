<?php

namespace App\Helpers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Format;

class ImageHelper
{
    public static function saveWebp($file, string $destinationDir, int $maxWidth = 1600): string
    {
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '.webp';

        $manager = ImageManager::usingDriver(GdDriver::class);
        $image   = $manager->decode($file->getRealPath());

        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $encoded = $image->encodeUsingFormat(Format::WEBP, quality: 78);
        $encoded->save($destinationDir . $filename);

        return $filename;
    }
}