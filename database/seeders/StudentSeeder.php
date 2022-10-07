<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $faker = Faker::create();
            //    $student = Student::factory(10)->create();
            //    $subject = Subject::factory(10)->create();



        $student = Student::pluck('id')->all();
        $subject = Subject::pluck('id')->all();
        for ($i =  1; $i <= 40; $i++) {
            DB::table('student_subject')->insert([
                'subject_id' => $faker->randomElement($subject),
                'student_id' => $faker->randomElement($student),
                'point' => rand(0, 10),
            ]);
        }
    }
}
