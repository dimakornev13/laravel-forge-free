<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Database\Seeder;

class SitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Site::create([
            'url' => 'uovgo.local'
        ]);

        Site::create([
            'url' => 'test.local'
        ]);
    }
}
