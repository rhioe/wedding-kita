<?php

// test-compression.php
echo "=== PHOTO COMPRESSION TEST ===\n\n";

// 1. Load Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

// 2. Setup paths
$photoPath = 'listings/photos/original/11/img-9936_6964dbbe7d956.jpg';
$fullPath = storage_path('app/public/'.$photoPath);

echo "Testing file: $fullPath\n";

// 3. Check if file exists
if (! file_exists($fullPath)) {
    exit("❌ ERROR: File not found!\n");
}

echo '✅ File exists ('.round(filesize($fullPath) / 1024)." KB)\n\n";

// 4. Test GD extension
echo "Checking GD extension:\n";
if (! extension_loaded('gd')) {
    exit("❌ ERROR: GD extension not loaded!\n");
}
echo "✅ GD is loaded\n";
print_r(gd_info());

// 5. Test Intervention Image
echo "\nTesting Intervention Image:\n";
try {
    // Method 1: Direct instantiation
    $manager = new Intervention\Image\ImageManager('gd');
    echo "✅ ImageManager created\n";

    // Try to load image
    $image = $manager->make($fullPath);
    echo '✅ Image loaded: '.$image->width().'x'.$image->height()."\n";

    // Test resize
    $image->resize(400, null, function ($constraint) {
        $constraint->aspectRatio();
    });
    echo "✅ Resize successful\n";

    // Test save
    $testOutput = storage_path('app/public/test_output.jpg');
    $image->save($testOutput, 85);
    echo "✅ Image saved to: $testOutput\n";
    echo '✅ New size: '.round(filesize($testOutput) / 1024)." KB\n";

    // Cleanup
    unlink($testOutput);

} catch (Exception $e) {
    echo '❌ ERROR: '.$e->getMessage()."\n";
    echo 'File: '.$e->getFile().':'.$e->getLine()."\n";
}

echo "\n=== TEST COMPLETE ===\n";
