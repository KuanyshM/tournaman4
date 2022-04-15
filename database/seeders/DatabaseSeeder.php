<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventComment;
use App\Models\Organization;
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
        Organization::factory()->count(2)->create();

        User::factory()->create([
            "name" => "Alice",
            "email" => "alice@gmail.com",
            'password' => Hash::make("password"),
            'organization_id' => 1,
        ]);
        User::factory()->create([
            "name" => "Bob",
            "email" => "bob@gmail.com",
            'password' => Hash::make("password"),
            'organization_id' => 2,
        ]);
        User::factory()->create([
            "name" => "Mike",
            "email" => "mike@gmail.com",
            'password' => Hash::make("password"),
            'organization_id' => 2,
        ]);
    }
}
