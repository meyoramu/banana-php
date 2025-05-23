<?php

use BananaPHP\Routing\Router;
use App\Controllers\HomeController;
use App\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group.
|
*/

Router::get('/', [HomeController::class, 'index'])->name('home');

Router::group(['prefix' => 'auth'], function () {
    Router::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Router::post('/login', [LoginController::class, 'login']);
    Router::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Router::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');