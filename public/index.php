<?php

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('register', ['controller' => 'User', 'action' => 'register']);
$router->add('login', ['controller' => 'User', 'action' => 'login']);
$router->add('logout', ['controller' => 'User', 'action' => 'logout']);
$router->add('admin', ['controller' => 'Admin', 'action' => 'dashboard']);
$router->add('edit', ['controller' => 'Admin', 'action' => 'edit']);
$router->add('{controller}/{action}');
$router->add('{controller}/{action}/{id:\d+}');
$router->dispatch($_SERVER['QUERY_STRING']);

