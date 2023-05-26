<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journee>
 */
class JourneeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => "Journé du xjxj ".$this->faker->word(),
            "calendrier" => Carbon::today()->toDate(),
            "ferie" => false

            //
        ];
    }
}
