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

// Filter in here, this url is only accessible when user doesn't have their business ID
$routes->get('business_signup', 'NomNomController::business_signup', ['filter' => 'login,owner']);

$routes->post('/upload', 'FileUploadController::upload');

$routes->get('/qrcode_gen/(:num)/(:num)', 'QrCodeGenerateController::generate/$1/$2');

$routes->post('/checkout', 'NomNomController::checkout');
$routes->get('/checkout', 'NomNomController::checkout');

// (:num) is menu id
$routes->get('menu/(:num)', 'NomNomController::menu/$1', ['filter' => 'login,owner']);

// (:num) is restaurant id == 1 (test data)
$routes->get('onlineorder/(:num)/(:num)', 'NomNomController::customer_view/$1/$2');

$routes->get('ordersystem', 'NomNomController::order_system',  ['filter' => 'login']);

$routes->get('admin/(:num)', 'NomNomController::admin/$1', ['filter' => 'owner']);
$routes->get('admin', 'NomNomController::admin', ['filter' => 'admin']);


$routes->group('menu/addedit', ['filter' => 'login,owner'], function($routes) {
    $routes->get('', 'NomNomController::menu_addedit'); // add
    $routes->get('(:num)', 'NomNomController::menu_addedit/$1'); // edit
    $routes->get('(:num)/(:num)', 'NomNomController::menu_addedit/$1/$2');
});

$routes->get('/google_login', 'Auth::google_login');  // Route to initiate Google login
$routes->get('/google_login/google_callback', 'Auth::google_callback');  // Callback route after Google auth
$routes->get('/google_logout', 'Auth::logout');

$routes->get('/(:num)', 'NomNomController::index/$1', ['filter' => 'login,owner']);

$routes->get('/', 'NomNomController::index');