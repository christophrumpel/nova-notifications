<?php

use Illuminate\Support\Facades\Route;
use Christophrumpel\NovaNotifications\Http\Controllers\NotifiableController;
use Christophrumpel\NovaNotifications\Http\Controllers\NotificationController;
use Christophrumpel\NovaNotifications\Http\Controllers\NotificationStatsController;
use Christophrumpel\NovaNotifications\Http\Controllers\NotificationClassesController;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/notifications', NotificationController::class.'@index');
Route::post('/notifications/send', NotificationController::class.'@send');
Route::get('/notifications/stats', NotificationStatsController::class.'@index');
Route::get('/notifications/classes', NotificationClassesController::class.'@index');
Route::get('/notifiables', NotifiableController::class.'@index');
