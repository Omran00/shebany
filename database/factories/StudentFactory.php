<?php

namespace Database\Factories;

use App\Models\Father;
use App\Models\Teacher;
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
        return [
            "first_name" => fake()->name(),
            "teacher_id"=> Teacher::inRandomOrder()->first(),
            "father_id"=> Father::inRandomOrder()->first(),
            "score"=>rand(0,144),
            "image"=>"storage/app/public/profiles/default.jpg",
            "class"=>rand(1,12),
            "is_approved"=>0
        ];
    }
}
