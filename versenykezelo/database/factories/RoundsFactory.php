<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Rounds;
use App\Models\Competitions;

class RoundsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Rounds::class;
    
    public function definition()
    {
        
        $competition = Competitions::inRandomOrder()->first();
        
        return [
           'roundNumber' => rand(1,8),
           'c_name' => $competition->name,
           'c_year' => $competition->year,

        ];
    }
}
