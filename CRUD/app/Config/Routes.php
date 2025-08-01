<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('saveUser', 'Home::saveUser');
$routes->get('getSingleUser/(:num)', 'Home::getSingleUser/$1');
