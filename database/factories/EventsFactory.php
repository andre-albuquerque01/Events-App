<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Events>
 */
class EventsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ids = File::pluck('id');
        $randomId = $ids[array_rand($ids)];
        return [
            'title' => fake()->name(),
            'description' => fake()->text(50),
            'price' => random_int(1, 100),
            'qtdParcelamento' => random_int(1, 100),
            'department' => fake()->text(20),
            'dateEvent' => fake()->date(),
            'timeEvent' => fake()->time(),
            'occupation' => random_int(1, 100),
            'statusEvent' => random_int(0, 1),
            'idFile' => random_int(1, 19),
            // '' => Str::random(10),
        ];
    }
}
