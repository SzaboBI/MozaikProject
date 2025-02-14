<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $city = $this->faker->randomElement([
            'Szeged',
            'Debrecen',
            'Nyiregyhaza',
            'Budapest',
            'Gyor',
        ]);
        $road = $this->faker->randomElement([
            'Kossuth utca',
            'Vasvari utca',
            'Szechenyi utca',
            'Kis utca',
            'Nagy fasor',
        ]);
        return [
            'fullname' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'postcode' => rand(1000,9999),
            'city' => $city,
            'road' => $road,
            'houseNumber' => rand(1,200),
            'telephone' => '+36' . strval(rand(20,99)) . strval(rand(1000000,9999999)),
            'admin' => rand(0,1),
            'remember_token' => Str::random(10),
        ];
    }
}
