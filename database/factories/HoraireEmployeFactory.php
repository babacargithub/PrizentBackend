<?php

namespace Database\Factories;

use App\Models\HoraireEmploye;
use Illuminate\Database\Eloquent\Factories\Factory;

class HoraireEmployeFactory extends Factory
{
    protected $model = HoraireEmploye::class;

    public function definition(): array
    {
//        static $uniqueNumbers = []; // Keep track of generated numbers
//
//        $number = $this->faker->numberBetween(1, 7); // Generate unique number between 1 and 7
//        while (in_array($number, $uniqueNumbers)) {
//            $number = $this->faker->numberBetween(1, 7); // Generate a new number if it already exists
//        }
//        $uniqueNumbers[] = $number; // Add the generated number to the list
        $jour = $this->faker->numberBetween(1, 7);
        return [
            "jour" => $jour,
            "entree" => "08:00",
            "sortie" => "18:00",
            "repos" => $jour == 7 ? true : false
        ];
    }
}
