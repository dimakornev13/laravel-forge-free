<?php

namespace Database\Seeders;

use App\Models\LogEvent;
use Illuminate\Database\Seeder;

class LogEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LogEvent::factory()->count(30)->create();
    }
}

