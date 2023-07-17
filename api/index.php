<?php

declare(strict_types=1);

require dirname(__DIR__) . "/vendor/autoload.php";


$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$parts = explode("/", $path);

$resource = $parts[4];

$id = $parts[5] ?? null;

if ($resource != "estates") {
    http_response_code(404);
    exit();

}


$controller = new EstateController();

$controller->processRequest($method, $id);