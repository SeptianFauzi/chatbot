<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/ping', function () use ($router) {
    return 'pong';
});

$router->post('/ping', function () use ($router) {
    return 'pong';
});

$router->post('webhook', [
    'as' => 'bot', 'uses' => 'WebhookController@bot'
]);

$router->get('verify/{token}', [
    'as' => 'bot', 'uses' => 'SendEmailController@verify'
]);

$router->get('/kuki', [
    'as' => 'kudapan', 'uses' => 'CobaCobaController@setCache'
]);

$router->get('/kudapan', [
    'as' => 'kudapan', 'uses' => 'CobaCobaController@getCache'
]);
