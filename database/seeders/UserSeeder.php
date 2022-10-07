<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        return [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'password' => bcrypt('123'),
        ];
    }
}
