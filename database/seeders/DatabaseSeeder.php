<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventComment;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Article::factory()->count(20)->create();
        Category::factory()->count(5)->create();
        Comment::factory()->count(40)->create();
        Event::factory()->count(15)->create();
        EventComment::factory()->count(15)->create();

        User::factory()->create([
            "name" => "Alice",
            "email" => "alice@gmail.com",
            'password' => Hash::make("password"),
        ]);
        User::factory()->create([
            "name" => "Bob",
            "email" => "bob@gmail.com",
            'password' => Hash::make("password"),
        ]);
    }
}
