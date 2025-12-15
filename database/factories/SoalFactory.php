<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Soal>
 */
class SoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get random ujian_id from existing ujian
        $ujianId = \App\Models\Ujian::inRandomOrder()->first()?->id ?? \App\Models\Ujian::factory()->create()->id;
        
        return [
            'ujian_id' => $ujianId,
            'soal' => fake()->paragraph(3),
        ];
    }
}
