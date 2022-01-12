<?php

namespace App\Providers;

use App\Services\Certificate\CertificateObtain;
use App\Services\Certificate\LetsEncrypt;
use App\Services\Deploy\Deploy;
use App\Services\Deploy\DeployImplement;
use App\Services\Logger\DbLogger;
use App\Services\Logger\Logger;
use App\Services\Nginx\CreateVhost;
use App\Services\Nginx\DeleteVhost;
use App\Services\Nginx\NginxRestart;
use App\Services\Nginx\NginxCreateVhost;
use App\Services\Nginx\NginxDeleteVhost;
use App\Services\Nginx\ServerRestart;
use App\Services\Nginx\ServerStop;
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
        $this->app->bind(CertificateObtain::class, LetsEncrypt::class);
        $this->app->bind(Logger::class, DbLogger::class);
        $this->app->bind(Deploy::class, DeployImplement::class);

        $this->app->bind(ServerRestart::class, NginxRestart::class);

    }
}
