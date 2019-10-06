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

$router->post('driver/register','Driver@register');

$router->group(['prefix' => 'driver', 'middleware' => 'client'], function () use ($router) {
	$router->get('','Driver@index');
	$router->get('{id}','Driver@information');
	$router->put('{id}/update','Driver@update');
	$router->delete('{id}/delete','Driver@delete');
	$router->put('{id}/activate','Driver@activate');
	$router->put('{id}/deactivate','Driver@deactivate');

	$router->group(['prefix' => '{driver}/signboard'], function () use ($router) {
		$router->get('','Signboard@index');
		$router->post('add','Signboard@add');
		$router->put('update/{id}','Signboard@update');
		$router->delete('delete/{id}','Signboard@delete');

		$router->group(['prefix' => '{signboard}/route'], function () use ($router) {
			$router->get('','Route@index');
			$router->post('add','Route@add');
			$router->put('update/{id}','Route@update');
			$router->delete('delete/{id}','Route@delete');
		});
	});
});

$router->get('/key', function() {
    return str_random(32);
});

