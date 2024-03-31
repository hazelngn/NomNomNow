<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'NomNomController::login');
// $routes->get('signup/(:num)', 'NomNomController::signup/$1');

$routes->group('signup', function($routes) {
    $routes->get('/', 'NomNomController::signup');
    $routes->get('(:num)', 'NomNomController::signup/$1');
});

$routes->group('menu', function($routes) {
    $routes->get('/', 'NomNomController::menu');
    $routes->get('(:num)', 'NomNomController::menu/$1');
});

$routes->group('/', function($routes) {
    $routes->get('', 'NomNomController::index');
    // once the db is implemented, checking which business will not be done via url any more (security)
    $routes->get('(:alphanum)', 'NomNomController::index/$1');
});

