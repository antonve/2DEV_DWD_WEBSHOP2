<?php

// routes.php - Configuration of routes
// By Anton Van Eechaute

use Devine\Framework\Route;
use Devine\Framework\RouteCollection;

$route_collection = new RouteCollection();

// import routes
$route_collection->addCollection(include($project_dir . '/src/Devine/Shop/config/routes.php'));
$route_collection->addCollection(include($project_dir . '/src/Devine/User/config/routes.php'));

return $route_collection;
