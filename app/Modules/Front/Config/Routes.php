<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('front', ['namespace' => 'App\Modules\Front\Controllers'], function($subroutes){

	/*** Route for Dashboard ***/
	$subroutes->add('', 'Dashboard::index');
	$subroutes->add('dashboard', 'Dashboard::index');

});