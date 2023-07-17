<?php

declare(strict_types=1);

require dirname(__DIR__) . "/vendor/autoload.php";
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");


$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$parts = explode("/", $path);

$resource = $parts[4];

$id = $parts[5] ?? null;

if ($resource != "estates") {
    http_response_code(404);
    exit();

}

$database = new Database(
    $_ENV['DB_HOST'],
    $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $options ?? null
);


$estate_gateway = new EstateGateway($database);
$controller = new EstateController($estate_gateway);

$controller->processRequest($method, $id);