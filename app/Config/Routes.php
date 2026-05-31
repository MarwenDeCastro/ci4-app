<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('users', 'UserController::index');

$routes->post('users/upload', 'UserController::upload');

$routes->get('users/delete/(:num)', 'UserController::delete/$1');