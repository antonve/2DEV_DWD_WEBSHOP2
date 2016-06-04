<?php

// routes.php - Routes configuration for the User module
// By Anton Van Eechaute

use Devine\Framework\RouteCollection;
use Devine\Framework\Route;

$routes = new RouteCollection();
$routes->addRoute(new Route('login', '/user/login', 'Devine\User\Controller\UserController::loginAction'));
$routes->addRoute(new Route('register', '/user/register', 'Devine\User\Controller\UserController::registerAction'));
$routes->addRoute(new Route('logout', '/user/logout', 'Devine\User\Controller\UserController::logoutAction'));
$routes->addRoute(new Route('profile', '/user/profile', 'Devine\User\Controller\UserController::profileAction'));

return $routes;
