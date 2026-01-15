<?php

// app\Jobs\CompressListingPhotosJob.php

namespace App\Jobs;

use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CompressListingPhotosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $listingId;

    public function __construct($listingId)
    {
        $this->listingId = $listingId;
    }

    public function handle()
    {
        Log::info('🚀 Starting photo compression job for listing: '.$this->listingId);

        $listing = Listing::with('photos')->find($this->listingId);

        if (! $listing) {
            Log::error('❌ Listing not found for compression job: '.$this->listingId);

            return;
        }

        Log::info('📸 Processing '.$listing->photos->count().' photos for listing #'.$listing->id);

        foreach ($listing->photos as $photo) {
            try {
                // 1. Update status to processing
                $photo->update(['processing_status' => 'processing']);
                Log::info('   Processing photo #'.$photo->id.': '.$photo->path);

                // 2. Check if original file exists
                if (! Storage::exists($photo->path)) {
                    Log::warning('   ❌ Photo file not found: '.$photo->path);
                    $photo->update([
                        'processing_status' => 'failed',
                        'error_message' => 'Original file not found in storage',
                    ]);

                    continue;
                }

                // 3. Get file info
                $originalSize = Storage::size($photo->path);
                $originalSizeKB = round($originalSize / 1024, 2);
                Log::info('   Original size: '.$originalSizeKB.'KB');

                // 4. Create compressed path
                // Format: listings/photos/compressed/{listing_id}/{photo_filename}
                $filename = basename($photo->path);
                $compressedPath = 'listings/photos/compressed/'.$listing->id.'/'.$filename;

                // 5. Create directory if not exists
                $directory = 'listings/photos/compressed/'.$listing->id;
                if (! Storage::exists($directory)) {
                    Storage::makeDirectory($directory);
                }

                // 6. PHASE 1: SIMPLE COPY (No compression yet)
                // Nanti di Phase 2 kita tambah compression logic
                Storage::copy($photo->path, $compressedPath);

                // 7. Update database
                $photo->update([
                    'compressed_path' => $compressedPath,
                    'processing_status' => 'completed',
                    'compressed_at' => now(),
                    'original_size_kb' => $originalSizeKB,
                    'compressed_size_kb' => $originalSizeKB, // Sama karena belum di-compress
                ]);

                Log::info('   ✅ Photo #'.$photo->id.' processed. Saved to: '.$compressedPath);

            } catch (\Exception $e) {
                Log::error('   ❌ Failed to process photo #'.$photo->id, [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                $photo->update([
                    'processing_status' => 'failed',
                    'error_message' => 'Job error: '.substr($e->getMessage(), 0, 200),
                ]);
            }
        }

        // 8. Summary log
        $completed = $listing->photos()->where('processing_status', 'completed')->count();
        $failed = $listing->photos()->where('processing_status', 'failed')->count();

        Log::info('🎯 Compression job completed for listing #'.$listing->id);
        Log::info('   Total photos: '.$listing->photos->count());
        Log::info('   Completed: '.$completed);
        Log::info('   Failed: '.$failed);

        // 9. Update listing status jika perlu
        if ($completed > 0) {
            Log::info('   Listing #'.$listing->id.' now has '.$completed.' compressed photos ready');
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::critical('💥 CompressListingPhotosJob COMPLETELY FAILED for listing: '.$this->listingId, [
            'error' => $exception->getMessage(),
            'class' => get_class($exception),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
