<?php

use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */
//
//$routes->get('login', 'AuthController::login');
//$routes->post('attemptLogin', 'AuthController::attemptLogin');
//$routes->get('logout', 'AuthController::logout');

$routes->group('auth', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->post('attempt-login', 'AuthController::attemptLogin');
    $routes->get('logout', 'AuthController::logout');
});
