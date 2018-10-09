<?php

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

Route::any('webhook/{uri}', function ($uri) {
    $webhook = App\Models\Webhook::whereUri($uri)->first();

    if (is_null($webhook)) {
        abort(404);
    }

    $webhook->captureRequest(request());
});
