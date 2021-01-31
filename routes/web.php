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
        Route::get('/{site}', [Dashboard\SitesController::class, 'update'])->name('sites.update');
//        Route::post('/{site}', [Dashboard\SitesController::class, 'store'])->name('sites.store');
        Route::delete('/{site}', [Dashboard\SitesController::class, 'delete'])->name('sites.delete');
    });
});


require __DIR__ . '/auth.php';


