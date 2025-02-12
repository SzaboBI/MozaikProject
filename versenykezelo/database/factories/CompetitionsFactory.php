<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Competitions;

class CompetitionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    
     protected $model = Competitions::class;
    
    public function definition()
    {
        $name = $this->faker->randomElement([
            'Mozaik Tanulmanyi Verseny',
            'Matematika Orszagos Verseny',
            'Edes Anyanyelvunk Verseny',
        ]);
        return [
            'name' => $name,
            'year' => $this->faker->unique()->numberBetween(2000,2024),
            'pointsForGoodAnswer' => rand(1,5),
            'pointsForBadAnswer' => rand(-3,0),
            'poinstForEmptyAnswer' => rand(-1,0),
        ];
    }
}
