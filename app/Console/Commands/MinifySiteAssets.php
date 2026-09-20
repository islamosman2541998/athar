<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MinifySiteAssets extends Command
{
    protected $signature = 'site:minify';

    protected $description = 'Build public/site/css/athar.min.css and public/site/js/athar.min.js from the source files';

    public function handle(): int
    {
        $css = public_path('site/css/athar.css');
        $js = public_path('site/js/athar.js');

        $this->write($css, public_path('site/css/athar.min.css'), $this->minifyCss(file_get_contents($css)));
        $this->write($js, public_path('site/js/athar.min.js'), $this->minifyJs(file_get_contents($js)));

        return self::SUCCESS;
    }

    private function write(string $source, string $target, string $contents): void
    {
        file_put_contents($target, $contents);
        $from = filesize($source);
        $to = strlen($contents);
        $this->info(sprintf('%s: %s KB -> %s KB', basename($target), round($from / 1024, 1), round($to / 1024, 1)));
    }

    private function minifyCss(string $css): string
    {
        $css = preg_replace('~/\*(?!!).*?\*/~s', '', $css);          // comments
        $css = preg_replace('/\s+/', ' ', $css);                      // collapse whitespace
        $css = preg_replace('/\s*([{}:;,>])\s*/', '$1', $css);        // around separators
        $css = str_replace(';}', '}', $css);

        return trim($css);
    }

    /**
     * Conservative: drops comments and indentation but keeps line breaks,
     * so no automatic-semicolon-insertion surprises.
     */
    private function minifyJs(string $js): string
    {
        $lines = [];
        foreach (explode("\n", $js) as $line) {
            $trimmed = trim($line);
            if ($trimmed === '' || str_starts_with($trimmed, '//')) {
                continue;
            }
            $lines[] = $trimmed;
        }

        return implode("\n", $lines);
    }
}
