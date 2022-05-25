<?php

namespace Database\Seeders;

use App\Models\TeamStatus;
use Illuminate\Database\Seeder;

class TeamStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TeamStatus::factory()->create([
            "name" => "request",
        ]);
        TeamStatus::factory()->create([
            "name" => "accept",
        ]);
    }
}
