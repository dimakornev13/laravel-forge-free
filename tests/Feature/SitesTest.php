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
            'url' => 'uovgo.ru'
        ];

        $response = $this->actingAs($this->getUser())->put(route('sites.store'), $parameters);

        $site = Site::where('url', $parameters['url'])->first();

        $response->assertRedirect(route('sites.view', ['site' => $site]));

        $this->assertDatabaseHas((new Site())->getTable(), $parameters);
        $this->assertDatabaseCount((new Site())->getTable(), 3);
        $this->assertNotEmpty($site->getDeployScript());

        dump($site->getDeployScript());

        Event::assertDispatched(SiteCreated::class);
    }

    /**
     * @return void
     */
    public function test_site_updated_successful()
    {
        $this->seed();

        $this->withoutExceptionHandling();

        Event::fake();

        $site = Site::first();

        $parameters = [
            'deploy_script' => 'some script',
            'environment' => 'some environment',
            'repository' => 'some repository'
        ];

        $response = $this->actingAs($this->getUser())->post(route('sites.update', ['site' => $site]), $parameters);

        $site = Site::first();

        $this->assertEquals($parameters['deploy_script'], $site->getDeployScript());
        $this->assertEquals($parameters['repository'], $site->getRepository());
        $this->assertEquals($parameters['environment'], $site->getEnvironment());
    }
}
