<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "event_id" => rand(1, 20),
            "user_id" => rand(1, 2),
        ];
    }
}
