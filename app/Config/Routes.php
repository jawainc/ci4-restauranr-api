<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 *
 * Add this block to your project's existing app/Config/Routes.php
 * (keep CodeIgniter's default routes above/below as needed).
 */

$routes->group('api', ['namespace' => 'App\Controllers\Api', 'filter' => 'apikey'], static function (RouteCollection $routes) {
    $routes->get('categories', 'CategoryController::index');
    $routes->get('categories/(:num)', 'CategoryController::show/$1');
    $routes->post('categories', 'CategoryController::create');
    $routes->put('categories/(:num)', 'CategoryController::update/$1');
    $routes->delete('categories/(:num)', 'CategoryController::delete/$1');

    $routes->get('products', 'ProductController::index');
    $routes->get('products/(:num)', 'ProductController::show/$1');
    $routes->post('products', 'ProductController::create');
    $routes->put('products/(:num)', 'ProductController::update/$1');
    $routes->delete('products/(:num)', 'ProductController::delete/$1');
});
