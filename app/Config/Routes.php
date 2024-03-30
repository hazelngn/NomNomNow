<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'NomNomController::index');
$routes->get('/login', 'NomNomController::login');
$routes->get('/signup/(:num)', 'NomNomController::signup/$1');
$routes->get('/signup', 'NomNomController::signup');