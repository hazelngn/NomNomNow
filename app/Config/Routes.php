<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('login', 'NomNomController::login');
// $routes->get('signup/(:num)', 'NomNomController::signup/$1');

$routes->group('signup', function($routes) {
    $routes->get('/', 'NomNomController::signup');
    $routes->get('(:num)', 'NomNomController::signup/$1');
});

$routes->get('menu', 'NomNomController::menu');
// (:num) is restaurant id == 1 (test data)
$routes->get('onlineorder/(:num)', 'NomNomController::customer_view/$1');
$routes->get('ordersystem', 'NomNomController::order_system');
$routes->get('admin', 'NomNomController::admin');

$routes->group('menu/addedit', function($routes) {
    $routes->get('', 'NomNomController::menu_addedit'); // add
    $routes->get('(:num)', 'NomNomController::menu_addedit/$1'); // edit
    $routes->match(['get', 'post'],'(:num)/(:num)', 'NomNomController::menu_addedit/$1/$2');
});

$routes->group('/', function($routes) {
    $routes->get('', 'NomNomController::index');
    // once the db is implemented, checking which business will not be done via url any more (security)
    $routes->get('(:alphanum)', 'NomNomController::index/$1');
});

