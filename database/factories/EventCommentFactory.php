<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "content" => $this->faker->paragraph,
            "event_id" => rand(1, 20),
            "user_id" => rand(1, 2),
        ];
    }
}
