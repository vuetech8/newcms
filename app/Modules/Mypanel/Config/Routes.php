<?php
    if(!isset($routes)){
        $routes = \Config\Services::routes(true);
    }

    $routes->match(['get','post'],'/mypanel/login', '\App\Modules\Mypanel\Controllers\Login::index',['filter'=>'noauth']);

    $routes->group('mypanel', ['namespace' => 'App\Modules\Mypanel\Controllers'], function($subroutes){
        $subroutes->add('', 'Login::index',['filter'=>'noauth']);
        $subroutes->add('dashboard', 'Mypanel::dashboard',['filter'=>'auth']);
        $subroutes->add('logout', 'Mypanel::logout',['filter'=>'auth']);
        $subroutes->add('nav', 'Mypanel::nav',['filter'=>'auth']);
        $subroutes->add('nav/(:any)', 'Mypanel::nav/$1',['filter'=>'auth']);
        $subroutes->add('nav/(:any)/(:any)', 'Mypanel::nav/$1/$2',['filter'=>'auth']);
        
        
        $subroutes->add('navigation', 'Mypanel::navigation',['filter'=>'auth']);
        $subroutes->add('navigation/(:any)', 'Mypanel::navigation/$1',['filter'=>'auth']);
        $subroutes->add('navigation/(:any)/(:any)', 'Mypanel::navigationnav/$1/$2',['filter'=>'auth']);
        $subroutes->add('page', 'Mypanel::page',['filter'=>'auth']);
        //$subroutes->add('dashboard2', 'Mypanel::index',['filter'=>'auth']);
    });

    $routes->group('mypanel/action', ['namespace' => 'App\Modules\Mypanel\Controllers'], function($subroutes){
        $subroutes->match(['get','post'],'nav', 'Action::nav',['filter'=>'auth']);
        $subroutes->match(['get','post'],'nav/(:any)', 'Action::nav/$1',['filter'=>'auth']);
        $subroutes->match(['get','post'],'nav/(:any)/(:any)', 'Action::nav/$1/$2',['filter'=>'auth']);

        $subroutes->match(['get','post'],'navigation/(:any)', 'Action::navigation/$1',['filter'=>'auth']);
        $subroutes->match(['get','post'],'navigation/(:any)/(:any)', 'Action::navigation/$1/$2',['filter'=>'auth']);
    });



?>