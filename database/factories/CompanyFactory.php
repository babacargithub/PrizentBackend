<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
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
            "telephone" => intval("77".$this->faker->numberBetween(1111111,9999999)),
            "email" => $this->faker->email(),
            "longitude" => $this->faker->longitude(),
            "latitude" => $this->faker->latitude(),
            "adresse" => $this->faker->address(),
            "logo" => $this->faker->url(),
            "region" => $this->faker->word()
            //
        ];
    }
}
