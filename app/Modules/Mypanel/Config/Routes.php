<?php

$routes->get('/mypanels', 'App\Modules\Mypanel\Controllers\Mypanel::index',['filter'=>'auth']);

/*if(!isset($routes)){
    $routes = \Config\Services::routes(true);
}

$routes->group('mypanel', ['namespace' => 'App\Modules\Mypanel\Controllers'], function($subroutes){
	$subroutes->add('', 'Login::index',['filter'=>'noauth']);
    $subroutes->add('dashboard', 'Mypanel::index',['filter'=>'auth']);
	$subroutes->add('dashboard2', 'Mypanel::index',['filter'=>'auth']);
});*/



?>