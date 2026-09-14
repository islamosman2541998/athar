<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Format;

class ConvertImagesToWebp extends Command
{
    protected $signature = 'images:webp {--dir=attachments : المجلد داخل public} {--width=1600} {--quality=78}';
    protected $description = 'يحوّل صور JPG/PNG الموجودة إلى WebP مضغوط';

    public function handle()
    {
        $baseDir = public_path($this->option('dir'));
        $maxW    = (int) $this->option('width');
        $quality = (int) $this->option('quality');

        if (!is_dir($baseDir)) {
            $this->error("المجلد غير موجود: $baseDir");
            return 1;
        }

        $manager = ImageManager::usingDriver(GdDriver::class);

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($baseDir, \FilesystemIterator::SKIP_DOTS)
        );

        $count = 0;
        foreach ($files as $file) {
            $ext = strtolower($file->getExtension());
            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                continue;
            }

            $original = $file->getPathname();
            $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $original);

            if (file_exists($webpPath)) {
                continue;
            }

            try {
                $image = $manager->decode($original);
                if ($image->width() > $maxW) {
                    $image->scale(width: $maxW);
                }
                $image->encodeUsingFormat(Format::WEBP, quality: $quality)->save($webpPath);
                $count++;
                $this->line("[OK] " . basename($webpPath));
            } catch (\Throwable $e) {
                $this->warn("[FAIL] " . basename($original) . " - " . $e->getMessage());
            }
        }

        $this->info("تم تحويل $count صورة.");
        return 0;
    }
}