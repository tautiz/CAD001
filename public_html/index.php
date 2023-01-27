<?php

use Appsas\Controllers\AddressController;
use Appsas\Controllers\AdminController;
use Appsas\Controllers\KontaktaiController;
use Appsas\Controllers\PersonController;
use Appsas\Controllers\PradziaController;
use Appsas\Controllers\UserController;
use Appsas\ExceptionHandler;
use Appsas\Output;
use Appsas\Router;
use DI\ContainerBuilder;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/larapack/dd/src/helper.php';

$log = new Logger('Portfolios');
$log->pushHandler(new StreamHandler('../logs/klaidos.log', Logger::INFO));

$output = new Output();

try {
    session_start();

    $containerBuilder = new ContainerBuilder();
    $container = $containerBuilder->build();

    $adminController = $container->get(AdminController::class);
    $contactsController = $container->get(KontaktaiController::class);
    $personController = $container->get(PersonController::class);
    $userController = $container->get(UserController::class);
    $addressController = $container->get(AddressController::class);

    /** @var Router $router */
    $router = $container->get(Router::class);
    $router->addRoute('GET', '', [$container->get(PradziaController::class), 'index']);
    $router->addRoute('GET', 'admin', [$adminController, 'index']);
    $router->addRoute('POST', 'login', [$adminController, 'login']);
    $router->addRoute('GET', 'logout', [$adminController, 'logout']);
    $router->addRoute('GET', 'kontaktai', [$contactsController, 'index']);

    $router->resource('person', $personController);
    $router->resource('user', $userController);
    $router->resource('address', $addressController);

    $router->run();
}
catch (Exception $e) {
    $handler = new ExceptionHandler($output, $log);
    $handler->handle($e);
    $output->print();
}
