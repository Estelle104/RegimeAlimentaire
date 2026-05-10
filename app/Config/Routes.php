<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'FrontOffice\UserController::index');
$routes->get('/', 'FrontOffice\UserController::PageInscription');

// $routes->post('/frontoffice/inscription', 'FrontOffice\UserController::InsertionInscription');

$routes->group('frontoffice', function ($routes) {
    // $routes->get('inscription', 'FrontOffice\UserController::PageInscription');
    $routes->post('inscription', 'FrontOffice\UserController::InsertionInscription');
});

$routes->group('backoffice', function ($routes) {
    $routes->get('regimes', 'BackOffice\RegimeController::index');
    $routes->post('regimes/create', 'BackOffice\RegimeController::create');

    $routes->get('regimes/update/(:num)', 'BackOffice\RegimeController::update/$1');
    $routes->post('regimes/update/(:num)', 'BackOffice\RegimeController::updateAction/$1');
    $routes->get('regimes/delete/(:num)', 'BackOffice\RegimeController::delete/$1');
});
