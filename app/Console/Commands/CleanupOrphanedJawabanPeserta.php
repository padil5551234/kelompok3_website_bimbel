<?php

namespace App\Console\Commands;

use App\Models\JawabanPeserta;
use Illuminate\Console\Command;

class CleanupOrphanedJawabanPeserta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:orphaned-jawaban';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up orphaned JawabanPeserta records that have no valid Soal relationship';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting cleanup of orphaned JawabanPeserta records...');

        // Find all JawabanPeserta records without valid soal_id
        $orphanedRecords = JawabanPeserta::whereDoesntHave('soal')->get();
        
        $count = $orphanedRecords->count();
        
        if ($count === 0) {
            $this->info('No orphaned records found.');
            return 0;
        }

        $this->warn("Found {$count} orphaned records.");
        
        if ($this->confirm('Do you want to delete these orphaned records?')) {
            JawabanPeserta::whereDoesntHave('soal')->delete();
            $this->info("Successfully deleted {$count} orphaned JawabanPeserta records.");
        } else {
            $this->info('Cleanup cancelled.');
        }

        return 0;
    }
}