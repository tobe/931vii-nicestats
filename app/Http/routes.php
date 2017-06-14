<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Home sweet home
$app->get('/', 'App\Http\Controllers\IndexController@index');

// Global status
$app->get('status', ['as' => 'status', 'uses' => 'App\Http\Controllers\IndexController@status']);

// Errors
$app->get('errors', ['as' => 'errors', 'uses' => 'App\Http\Controllers\ErrorController@errors']);

// Attenuation
$app->get('attenuation', ['as' => 'attenuation', 'uses' => 'App\Http\Controllers\AttenuationController@index']);

// SNR
$app->get('snr', ['as' => 'snr', 'uses' => 'App\Http\Controllers\AttenuationController@snr']);

// Sync
$app->get('sync', ['as' => 'sync', 'uses' => 'App\Http\Controllers\AttenuationController@sync']);

// Power!
$app->get('power', ['as' => 'power', 'uses' => 'App\Http\Controllers\AttenuationController@power']);

// Exchange?
$app->get('exchange', ['as' => 'exchange', 'uses' => 'App\Http\Controllers\SystemController@exchange']);

// Subnet...
$app->get('subnet', ['as' => 'subnet', 'uses' => 'App\Http\Controllers\SystemController@subnet']);

// Raw output.
$app->get('raw/{id:[1-9]+}', ['as' => 'raw', 'uses' => 'App\Http\Controllers\IndexController@raw']);

// System stuff
$app->get('system', ['as' => 'system', 'uses' => 'App\Http\Controllers\SystemController@system']);

// Not added yet...
$app->get('cron', ['as' => 'cron', 'uses' => 'App\Http\Controllers\IndexController@cron']);