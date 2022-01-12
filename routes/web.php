<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/', [Dashboard\DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('sites')->group(function () {
        Route::get('/', [Dashboard\SitesController::class, 'index'])->name('sites.index');
        Route::get('/create/', [Dashboard\SitesController::class, 'create'])->name('sites.create');
        Route::put('/', [Dashboard\SitesController::class, 'store'])->name('sites.store');
        Route::get('/{site}', [Dashboard\SitesController::class, 'view'])->name('sites.view');
        Route::post('/{site}', [Dashboard\SitesController::class, 'update'])->name('sites.update');
        Route::delete('/{site}', [Dashboard\SitesController::class, 'delete'])->name('sites.delete');
    });

    Route::prefix('deploy')->group(function (){
        Route::get('/{site}', [Dashboard\DeployController::class, 'index'])->name('deploy');
        Route::get('/{site}/do-deploy', [Dashboard\DeployController::class, 'deploy'])->name('deploy.do');
    });

    Route::prefix('queue')->group(function (){
        Route::get('/{site}', [Dashboard\QueueController::class, 'index'])->name('queue');
        Route::put('/', [Dashboard\QueueController::class, 'store'])->name('queue.store');
        Route::delete('/{queue}', [Dashboard\QueueController::class, 'delete'])->name('queue.delete');
    });

    Route::prefix('ssl')->group(function (){
        Route::get('/{site}', [Dashboard\SslController::class, 'index'])->name('ssl');
        Route::put('/{site}', [Dashboard\SslController::class, 'store'])->name('ssl.obtain');
    });

    Route::prefix('nginx')->group(function (){
        Route::get('/restart', [Dashboard\NginxController::class, 'restart'])->name('nginx.restart');
    });

    Route::prefix('php')->group(function (){
        Route::get('/restart', [Dashboard\PhpController::class, 'restart'])->name('php.restart');
    });

    Route::prefix('supervisor')->group(function (){
        Route::get('/restart', [Dashboard\SupervisordController::class, 'restart'])->name('supervisor.restart');
    });
});


require __DIR__ . '/auth.php';


