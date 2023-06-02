<?php

namespace Database\Factories;

use App\Models\Employe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employe>
 */
class EmployeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nom" => $this->faker->lastName(),
            "email" => $this->faker->email(),
            "telephone" => intval("77".$this->faker->numberBetween(1111111,9999999)),
            "sexe" => $this->faker->randomLetter(),
            "prenom" => $this->faker->firstName()
            //
        ];
    }
    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function pointeur(): static
    {
        return $this->state(fn (array $attributes) => [
            ['pointeur' => false],
            ['pointeur' => true],
        ]);
    }
}
