<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('front', ['namespace' => 'App\Modules\Front\Controllers'], function($subroutes){
 
	$subroutes->add('', 'Login::index',['filter'=>'noauth']);
	$subroutes->add('dashboard', 'Dashboard::index',['filter'=>'auth']);
	$subroutes->add('dashboard2', 'Dashboard::index',['filter'=>'auth']);

});