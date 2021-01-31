<?php

namespace Tests\Feature;

use App\Events\SiteCreated;
use App\Models\Site;
use App\Repositories\SitesRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SitesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_list_sites_successful()
    {
        $this->seed();

        $response = $this->actingAs($this->getUser())->get(route('sites.index'));

        $response->assertStatus(200);

        resolve(SitesRepository::class)->getAvailableSites()->each(function (Site $site) use ($response){
            $response->assertSee($site->getUrl());
        });
    }

    /**
     * @return void
     */
    public function test_delete_site_successful()
    {
        $this->seed();

        $site = Site::first();

        $response = $this->actingAs($this->getUser())->delete(route('sites.delete', ['site' => $site]));

        $response->assertRedirect(route('sites.index'));

        $this->assertDatabaseMissing((new Site())->getTable(), [
            'url' => $site->getUrl()
        ]);
    }

    /**
     * @return void
     */
    public function test_creating_page()
    {
        $response = $this->actingAs($this->getUser())->get(route('sites.view'));

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_site_created_successful()
    {
        $this->seed();

        Event::fake();

        $parameters = [
            'url' => 'uovgo.local'
        ];

        $response = $this->actingAs($this->getUser())->put(route('sites.store'), $parameters);

        $response->assertRedirect(route('sites.index'));

        $this->assertDatabaseHas((new Site())->getTable(), $parameters);
        $this->assertDatabaseCount((new Site())->getTable(), 3);

        Event::assertDispatched(SiteCreated::class);
    }
}
