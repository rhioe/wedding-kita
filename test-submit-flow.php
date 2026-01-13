// Buat file: test-submit-flow.php di root
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Listing;
use App\Models\ListingPhoto;

echo "=== TEST SUBMIT FLOW ===\n\n";

// 1. Cek listing terakhir
$lastListing = Listing::latest()->first();
if (!$lastListing) {
    echo "❌ No listings found\n";
    exit;
}

echo "📋 Last Listing:\n";
echo "   ID: {$lastListing->id}\n";
echo "   Status: {$lastListing->status}\n";
echo "   Created: {$lastListing->created_at}\n\n";

// 2. Cek photos
$photos = $lastListing->photos;
echo "📸 Photos ({$photos->count()}):\n";

if ($photos->count() === 0) {
    echo "   ❌ No photos found\n";
    exit;
}

foreach ($photos as $photo) {
    echo "\n   Photo ID: {$photo->id}\n";
    echo "   Path: {$photo->path}\n";
    echo "   Compressed Path: " . ($photo->compressed_path ?: 'NULL') . "\n";
    echo "   Status: {$photo->processing_status}\n";
    echo "   Size: " . ($photo->original_size_kb ?: '0') . "KB\n";
    
    // Cek file exists
    $originalExists = \Storage::exists($photo->path);
    echo "   Original exists: " . ($originalExists ? '✅' : '❌') . "\n";
    
    if ($photo->compressed_path) {
        $compressedExists = \Storage::disk('public')->exists($photo->compressed_path);
        echo "   Compressed exists: " . ($compressedExists ? '✅' : '❌') . "\n";
        
        if ($compressedExists) {
            $size = \Storage::disk('public')->size($photo->compressed_path) / 1024;
            echo "   Compressed size: {$size}KB\n";
        }
    }
}

echo "\n=== ANALYSIS ===\n";

// Analisis
if ($photos->where('processing_status', 'compressed')->count() > 0) {
    echo "✅ Some photos are compressed\n";
} else {
    echo "❌ NO photos are compressed\n";
    echo "   Processing status: " . $photos->pluck('processing_status')->unique()->implode(', ') . "\n";
}

if ($photos->whereNotNull('compressed_path')->count() > 0) {
    echo "✅ Some have compressed_path\n";
} else {
    echo "❌ NO compressed_path set\n";
}

echo "\n=== CHECK LOGS ===\n";
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $lastLines = shell_exec('tail -n 50 "' . $logFile . '" 2>&1');
    echo "Last 50 lines of laravel.log:\n";
    echo $lastLines ?: "   (No output)\n";
} else {
    echo "Log file not found\n";
}