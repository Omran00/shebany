<?php

namespace Database\Factories;

use App\Models\Rating;
use App\Models\Session;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "session_id"=>Session::inRandomOrder()->first(),
            "student_id"=>Student::inRandomOrder()->first(),
            "subject_id"=>Subject::inRandomOrder()->first(),
            "rate"=>rand(0,10)
        ];
    }
}
