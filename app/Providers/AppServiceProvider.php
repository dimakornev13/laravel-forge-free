<?php

namespace App\Providers;

use App\Services\Nginx\CreateVhost;
use App\Services\Nginx\DeleteVhost;
use App\Services\Nginx\NginxCreateVhost;
use App\Services\Nginx\NginxDeleteVhost;
use App\View\Components\ConfirmModalDelete;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('confirm-modal-delete', ConfirmModalDelete::class);

        $this->app->bind(CreateVhost::class, NginxCreateVhost::class);
        $this->app->bind(DeleteVhost::class, NginxDeleteVhost::class);
    }
}
