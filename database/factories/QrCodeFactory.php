<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QrCode>
 */
class QrCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nom" => $this->faker->company(),
            "latitude" => $this->faker->latitude(),
            "longitude" => $this->faker->longitude(),
            "maximum_distance" => $this->faker->numberBetween(2000,9000),
            "disabled" => false,
            "type" => 1,
        ];
    }
}
