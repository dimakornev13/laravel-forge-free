<?php

namespace Tests\Feature;

use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CronTest extends TestCase
{
    use RefreshDatabase;

    function test_cron_deleted_successful()
    {
        $cronContent = <<<EOF
* * * * * /usr/bin/php /home/forge/site1.ru/www/artisan schedule:run >> /dev/null 2>&1
* * * * * /usr/bin/php /home/forge/site2.ru/www/artisan schedule:run >> /dev/null 2>&1
EOF;

        $site = Site::create([
            'url' => 'site2.ru'
        ]);

        $cronContent = collect(explode("\n", $cronContent))->filter(function ($line) use ($site) {
            return stripos($line, $site->getUrl()) === false;
        })->implode("\n");

//        dump($cronContent);
    }
}
