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

$router->post('/register', 'Auth@register');
$router->post('/login', 'Auth@login');

$router->group(['prefix' => 'profile/', 'middleware' => 'client'], function() use ($router) {

	$router->post('register', 'Profile@register');

	$router->get('{profile_id}', 'Profile@index');
	$router->get('{profile_id}/orders', 'Profile@orders');
	$router->put('{profile_id}/update', 'Profile@update');

	$router->group(['prefix' => '{profile_id}/'], function() use ($router) {

		$router->get('store', 'Store@index');
		$router->post('store/add', 'Store@add');
		$router->put('store/{store_id}/update', 'Store@update');
		$router->delete('store/{store_id}/delete', 'Store@delete');

		$router->group(['prefix' => 'store/'], function() use ($router) {

			$router->get('{store_id}/menu/', 'Menu@index');
			$router->post('{store_id}/menu/add', 'Menu@add');
			$router->put('{store_id}/menu/{menu_id}/update', 'Menu@update');
			$router->delete('{store_id}/menu/{menu_id}/delete', 'Menu@delete');		
		});
	});
});


$router->group(['prefix' => 'store/'], function() use ($router) {

	$router->post('{store_id}/menu/{menu_id}/order', 'Menu@order');
	$router->get('{store_id}/orders', 'Store@orders');
});
	

$router->get('/key', function() {
    return str_random(32);
});

