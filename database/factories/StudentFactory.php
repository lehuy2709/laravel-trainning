<?php

namespace Database\Factories;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->create();
        $faculty = Faculty::factory()->create();
        $user->assignRole('student');
        $user->givePermissionTo('read');
        return [
            'user_id' => $user->id,
            'email' => $user->email,
            'faculty_id' => $faculty->id,
            'name' => $user->name,
            'avatar' => 'userdefault.png',
            'phone' => '0584677817',
            'gender' => rand(0, 1),
            'birthday' => $this->faker->date,
            'address' => $this->faker->address,
        ];
    }
}
