<?php

use BananaPHP\Routing\Router;
use App\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group.
|
*/

Router::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Router::get('/user', [ApiController::class, 'user']);
    Router::resource('/posts', \App\Controllers\PostController::class);
});

Router::post('/auth/login', [ApiController::class, 'login']);
Router::post('/auth/register', [ApiController::class, 'register']);
Router::post('/auth/refresh', [ApiController::class, 'refresh']);