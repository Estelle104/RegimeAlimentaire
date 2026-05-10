<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'FrontOffice\UserController::PageInscription');

$routes->group('frontoffice', function ($routes) {
    $routes->post('inscription', 'FrontOffice\UserController::InsertionInscription');
    $routes->get('profil', 'FrontOffice\UserController::profil');
    $routes->post('recharge', 'FrontOffice\UserController::demanderRecharge');
    $routes->post('devenir-gold', 'FrontOffice\UserController::devenirGold');
});

$routes->group('backoffice', function ($routes) {
    $routes->get('regimes', 'BackOffice\RegimeController::index');
    $routes->get('dashboard', 'BackOffice\DashboardController::index');
    $routes->post('regimes/create', 'BackOffice\RegimeController::create');
    $routes->get('regimes/update/(:num)', 'BackOffice\RegimeController::update/$1');
    $routes->post('regimes/update/(:num)', 'BackOffice\RegimeController::updateAction/$1');
    $routes->get('regimes/delete/(:num)', 'BackOffice\RegimeController::delete/$1');
    
    
    $routes->get('recharges', 'BackOffice\AdminRechargeController::index');
    $routes->get('recharges/valider/(:num)', 'BackOffice\AdminRechargeController::valider/$1');
    $routes->get('recharges/refuser/(:num)', 'BackOffice\AdminRechargeController::refuser/$1');
});
