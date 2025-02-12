<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Competitions::factory(10)->create();
        \App\Models\Rounds::factory(10)
                ->has(\App\Models\Competitions::factory(10))
                ->create();
        foreach (\App\Models\Rounds::all() as $rounds){
            $users = \App\Models\User::inRandomOrder()->take(rand(1,3))->pluck('email');
            $rounds->users()->attach($users);
        }
    }
}
