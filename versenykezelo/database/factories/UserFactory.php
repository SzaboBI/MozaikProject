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
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'postcode' => rand(1000,9999),
            'city' => $city,
            'road' => $road,
            'houseNumber' => rand(1,200),
            'telephone' => '+36' . strval(rand(20,99)) . strval(rand(1000000,9999999)),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
