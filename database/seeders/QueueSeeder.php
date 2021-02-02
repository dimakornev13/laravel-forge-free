<?php

namespace Database\Seeders;

use App\Models\Queue;
use App\Models\Site;
use Illuminate\Database\Seeder;

class QueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Site::all()->each(function (Site $site){
            Queue::factory()->count(3)->create([
                'site_id' => $site->getId(),
                'timeout' => rand(0,10),
                'rest_seconds_when_empty' => rand(0,10),
                'failed_job_delay' => rand(0,10),
                'processes' => rand(0,10),
                'tries' => rand(0,10)
            ]);
        });
    }
}
