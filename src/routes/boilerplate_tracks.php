<?php
/**
 * Tracking boilerplate module
 * Routes
 *
 */

Route::group([
    'prefix' => config('boilerplate.app.prefix', ''),
    'namespace' => 'Cbwar\Laravel\BoilerplateTracks\Controllers',
    'middleware' => ['web', 'auth', 'ability:admin,backend_access']
], function () {

    Route::group(['prefix' => 'tracks', 'as' => 'tracks.'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'TracksController@index']);
        Route::any('/index_xhr_dt', ['as' => 'index_xhr_dt', 'uses' => 'TracksController@index_xhr_dt']);
    });

});