<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCompressionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-compression-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing compression for listing 11...');

        try {
            $job = new \App\Jobs\CompressListingPhotosJob(11);
            $job->handle(); // Panggil langsung handle()

            $this->info('✅ Job executed successfully');
        } catch (\Exception $e) {
            $this->error('❌ Error: '.$e->getMessage());
        }
    }
}
