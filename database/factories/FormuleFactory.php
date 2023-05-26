<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formule>
 */
class FormuleFactory extends Factory
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
            "prix" => 20000,
            "unite" => "mois",
            "limite" => $this->faker->numberBetween(5,10),
            "duree" => 1,
            "comment" => $this->faker->sentence()
            //
        ];
    }
}
