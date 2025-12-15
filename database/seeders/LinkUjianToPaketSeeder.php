<?php

namespace Database\Seeders;

use App\Models\Ujian;
use App\Models\PaketUjian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinkUjianToPaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all packages and exams
        $paketUjian = PaketUjian::all();
        $ujian = Ujian::all();

        if ($paketUjian->isEmpty() || $ujian->isEmpty()) {
            $this->command->warn('No packages or exams found to link!');
            return;
        }

        // Distribute exams across packages
        $ujianPerPaket = ceil($ujian->count() / $paketUjian->count());
        
        foreach ($paketUjian as $index => $paket) {
            $startIndex = $index * $ujianPerPaket;
            $ujianForPaket = $ujian->slice($startIndex, $ujianPerPaket);
            
            foreach ($ujianForPaket as $exam) {
                // Link exam to package
                DB::table('paket_ujian_ujian')->insert([
                    'paket_ujian_id' => $paket->id,
                    'ujian_id' => $exam->id,
                ]);
                
                $this->command->info("Linked exam '{$exam->nama}' to package '{$paket->nama}'");
            }
        }

        $this->command->info('Successfully linked all exams to packages!');
    }
}