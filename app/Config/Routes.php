<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 // REST API
$routes->resource('users', ["controller" => "Rest_APIs\Users"]);
$routes->resource('businesses', ["controller" => "Rest_APIs\Businesses"]);
$routes->resource('menus', ["controller" => "Rest_APIs\Menus"]);
$routes->resource('menu_items', ["controller" => "Rest_APIs\MenuItems"]);
$routes->resource('categories', ["controller" => "Rest_APIs\Categories"]);
$routes->resource('diet_pref', ["controller" => "Rest_APIs\DietPrefs"]);
$routes->resource('diet_pref_items', ["controller" => "Rest_APIs\DietPrefItems"]);
$routes->resource('order_items', ["controller" => "Rest_APIs\OrderItems"]);
$routes->resource('orders', ["controller" => "Rest_APIs\Orders"]);
$routes->resource('customers', ["controller" => "Rest_APIs\Customers"]);

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



$routes->get('/google_login', 'Auth::google_login');  // Route to initiate Google login
$routes->get('/google_login/callback', 'Auth::google_callback');  // Callback route after Google auth
$routes->get('/google_logout', 'Auth::logout');

$routes->group('/', function($routes) {
    $routes->get('', 'NomNomController::index');
    // once the db is implemented, checking which business will not be done via url any more (security)
    $routes->get('(:alphanum)', 'NomNomController::index/$1');
});