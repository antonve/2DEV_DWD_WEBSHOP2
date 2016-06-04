<?php

// routes.php - Routes configuration for the Shop module
// By Anton Van Eechaute

use Devine\Framework\RouteCollection;
use Devine\Framework\Route;

$routes = new RouteCollection();
$routes->addRoute(new Route('home', '/', 'Devine\Shop\Controller\DefaultController::indexAction'));
$routes->addRoute(new Route('products', '/products', 'Devine\Shop\Controller\ShopController::indexAction'));
$routes->addRoute(new Route('search', '/search', 'Devine\Shop\Controller\ShopController::searchAction'));
$routes->addRoute(new Route('search_results', '/search/$query', 'Devine\Shop\Controller\ShopController::searchResultAction'));
$routes->addRoute(new Route('filter', '/products/filter', 'Devine\Shop\Controller\ShopController::filterAction'));
$routes->addRoute(new Route('filter_results', '/products/filter/$category/$type', 'Devine\Shop\Controller\ShopController::filterResultAction'));
$routes->addRoute(new Route('cart', '/cart', 'Devine\Shop\Controller\ShopController::cartAction'));
$routes->addRoute(new Route('cartAdd', '/cart/add/%id', 'Devine\Shop\Controller\ShopController::cartAddAction'));
$routes->addRoute(new Route('cartRemove', '/cart/remove/%id', 'Devine\Shop\Controller\ShopController::cartRemoveAction'));
$routes->addRoute(new Route('cartUpdate', '/cart/update/%id', 'Devine\Shop\Controller\ShopController::cartUpdateAction'));

return $routes;
