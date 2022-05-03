<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParticipationStatus;

class ParticipationStatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Request',
            'Participant',
            'Finalist',
            'Champion',

        ];

        ParticipationStatus::factory()->create(['name' => 'request','points' => 0]);
        ParticipationStatus::factory()->create(['name' => 'participant','points' => 500]);
        ParticipationStatus::factory()->create(['name' => 'finalist','points' => 1000]);
        ParticipationStatus::factory()->create(['name' => 'champion','points' => 1500]);


    }
}
