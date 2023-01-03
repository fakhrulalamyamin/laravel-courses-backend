<?php

namespace Database\Factories;

use App\Models\Platform;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->sentence(),
            'slug' => fake()->slug(),
            'type' => rand(0, 1),
            'resources' => rand(1, 50),
            'year' => rand(2010, 2022),
            'price' => rand(0, 1) ? rand(1, 100) : 0.00,
            'image' => fake()->imageUrl(640, 250),
            'description' => fake()->paragraph(),
            'link' => fake()->url(),
            'submitted_by' => User::all()->random()->id,
            'duration' => rand(0, 2),
            'difficulty_label' => rand(0, 2),
            'platform_id' => Platform::all()->random()->id
        ];
    }
}
