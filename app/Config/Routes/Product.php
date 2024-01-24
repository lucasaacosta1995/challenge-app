<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('producto', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function($routes) {
    $routes->get('/', 'ProductController::index');
    $routes->get('(:num)', 'ProductController::show/$1');
    $routes->post('/', 'ProductController::create');
    $routes->put('(:num)', 'ProductController::update/$1');
    $routes->post('delete/(:num)', 'ProductController::delete/$1');
});

$routes->get('ajax/producto/get-product-table', 'ProductController::getProductTable',['filter' => 'auth']);
