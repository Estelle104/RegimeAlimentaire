<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('backoffice', function ($routes) {
    $routes->get('regimes', 'BackOffice\RegimeController::index');
    $routes->post('regimes/create', 'BackOffice\RegimeController::create');

    $routes->get('regimes/update/(:num)', 'BackOffice\RegimeController::update/$1');
    $routes->post('regimes/update/(:num)', 'BackOffice\RegimeController::updateAction/$1');
    $routes->get('regimes/delete/(:num)', 'BackOffice\RegimeController::delete/$1');
});
