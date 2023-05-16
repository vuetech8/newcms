<?php

//$routes->get('/mypanel', 'App\Modules\Mypanel\Controllers\Mypanel::index');

if(!isset($routes)){
    $routes = \Config\Services::routes(true);
}

$routes->group('mypanel', ['namespace' => 'App\Modules\Mypanel\Controllers'], function($subroutes){
	$subroutes->add('', 'Mypanel::index');
    $subroutes->add('login', 'Mypanel::index');
});

?>