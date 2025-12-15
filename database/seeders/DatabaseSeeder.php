<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UjianSeeder;
use Database\Seeders\PaketUjianSeeder;
use Database\Seeders\SoalJawabanSeeder;
// use Database\Seeders\RolesAndPermissionsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            \Database\Seeders\RolesAndPermissionsSeeder::class,
            \Database\Seeders\AdminUserSeeder::class,
            \Database\Seeders\TutorSeeder::class,
            \Database\Seeders\RegularUserSeeder::class,
            \Database\Seeders\ProdiSeeder::class,
            \Database\Seeders\FormasiSeeder::class,
            \Database\Seeders\WilayahSeeder::class,
            // \Database\Seeders\PaketUjianSeeder::class,
            // \Database\Seeders\UjianSeeder::class,
            // \Database\Seeders\SoalJawabanSeeder::class,
        ]);
    }
}
