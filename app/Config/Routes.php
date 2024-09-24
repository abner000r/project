<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('register', 'Users::index');
$routes->post('register', 'Users::create');

$routes->get('activate-user/(:any)', 'User::activateUser/$1');
