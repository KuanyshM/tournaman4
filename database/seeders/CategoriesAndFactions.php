<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesAndFactions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->create([
            "name" => "Engineers",
        ]);
        Category::factory()->create([
            "name" => "Visionaries",
        ]);
        Category::factory()->create([
            "name" => "Entertainers",
        ]);
        Category::factory()->create([
            "name" => "Warriors",
        ]);
        Category::factory()->create([
            "name" => "Intellectuals",
        ]);
        Category::factory()->create([
            "name" => "Scholars",
        ]);



        Category::factory()->create([
            "name" => "Robotics",
            "parent_id" => "1",
        ]);
        Category::factory()->create([
            "name" => "Programming",
            "parent_id" => "1",
        ]);
        Category::factory()->create([
            "name" => "Rockets",
            "parent_id" => "1",
        ]);




        Category::factory()->create([
            "name" => "Drawing",
            "parent_id" => "2",
        ]);
        Category::factory()->create([
            "name" => "Creative Writing",
            "parent_id" => "2",
        ]);
        Category::factory()->create([
            "name" => "Pitch Competition",
            "parent_id" => "2",
        ]);



        Category::factory()->create([
            "name" => "Dancing",
            "parent_id" => "3",
        ]);
        Category::factory()->create([
            "name" => "Acting",
            "parent_id" => "3",
        ]);
        Category::factory()->create([
            "name" => "Singing",
            "parent_id" => "3",
        ]);


        Category::factory()->create([
            "name" => "Sport",
            "parent_id" => "4",
        ]);


        Category::factory()->create([
            "name" => "Debating",
            "parent_id" => "5",
        ]);
        Category::factory()->create([
            "name" => "History",
            "parent_id" => "5",
        ]);


        Category::factory()->create([
            "name" => "Biology",
            "parent_id" => "6",
        ]);
        Category::factory()->create([
            "name" => "Chemistry",
            "parent_id" => "6",
        ]);
        Category::factory()->create([
            "name" => "Math",
            "parent_id" => "6",
        ]);
        Category::factory()->create([
            "name" => "Physics",
            "parent_id" => "6",
        ]);
        Category::factory()->create([
            "name" => "Astronomy",
            "parent_id" => "6",
        ]);
        Category::factory()->create([
            "name" => "Geography",
            "parent_id" => "6",
        ]);

    }
}
