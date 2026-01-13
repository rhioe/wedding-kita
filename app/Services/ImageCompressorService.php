<?php
// app/Services/ImageCompressorService.php
namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;

class ImageCompressorService
{
    public function compressToMax120KB(string $imagePath): array
    {
        Log::info("Starting compression: {$imagePath}");

        $manager = new ImageManager(new Driver());

        // === LOAD IMAGE ===
        $image = $manager->read($imagePath);

        $width  = $image->width();
        $height = $image->height();

        Log::info("Original size: {$width}x{$height}");

        // === RESIZE MAX 1200px ===
        if ($width > 1200 || $height > 1200) {
            $image = $image->scaleDown(1200);
        }

        $quality = 85;
        $attempt = 0;
        $finalSize = 0;

        $tempPath = storage_path('app/temp_' . uniqid() . '.jpg');

        do {
            $image
                ->toJpeg(quality: $quality)
                ->save($tempPath);

            $finalSize = filesize($tempPath) / 1024;
            Log::info("Attempt {$attempt} | Quality {$quality} | Size {$finalSize}KB");

            if ($finalSize > 120) {
                $quality -= 10;
            }

            $attempt++;

        } while ($finalSize > 120 && $quality > 40 && $attempt < 6);

        // === HARD RESIZE IF STILL TOO BIG ===
        if ($finalSize > 120) {
            $image = $manager->read($imagePath)->scaleDown(800);

            $image->toJpeg(quality: 70)->save($tempPath);
            $finalSize = filesize($tempPath) / 1024;
        }

        $data = file_get_contents($tempPath);
        unlink($tempPath);

        Log::info("Compression finished: {$finalSize}KB");

        return [
            'data'      => $data,
            'size_kb'   => round($finalSize, 2),
            'quality'   => $quality,
            'width'     => $image->width(),
            'height'    => $image->height(),
        ];
    }
}
