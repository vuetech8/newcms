<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('front', ['namespace' => 'App\Modules\Front\Controllers'], function($subroutes){

	/*** Route for Dashboard a***/
	$subroutes->add('', 'Dashboard::index');
	$subroutes->add('dashboard', 'Dashboard::index');
	$subroutes->add('dashboard2', 'Dashboard::index');

});