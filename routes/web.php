<?php

use App\Http\Middleware\AccessToken;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GitHubWebhookController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\DeployWebhookController;
use App\Http\Controllers\UpdateTemperatureController;

Route::group(['middleware' => AccessToken::class], function () {
    Route::get('/', DashboardController::class);

    Route::post('temperature', UpdateTemperatureController::class);
});

Route::post('/webhook/github', [GitHubWebhookController::class, 'gitRepoReceivedPush']);

Route::post('/webhook/forge', [DeployWebhookController::class, 'forgeDeploy']);

Route::post('/misc/reload', [MiscController::class, 'reload']);
Route::post('/misc/push-image', [MiscController::class, 'pushImage']);


//Route::ohDearWebhooks('/oh-dear-webhooks');

