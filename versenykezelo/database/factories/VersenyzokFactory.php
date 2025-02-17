<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Rounds;
use App\Models\Versenyzok;
use App\Models\User;

class VersenyzokFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Versenyzok::class;
    
    public function definition()
    {

        $user_emails = User::all()->where('admin','=',0)->pluck('email')->toArray();
        $round = Rounds::inRandomOrder()->first();

        return [
            'u_email' => $this->faker->randomElement($this->user_emails),
            'r_id' => $round->id,
        ];
    }
}
