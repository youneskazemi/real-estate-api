<?php


require __DIR__."/bootstrap.php";

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$parts = explode("/", $path);

$resource = $parts[3];
$id = $parts[4] ?? null;

if ($resource != "ads") {
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


if ($resource === "ads") {

    $ads_gateway = new AdsGateway($database);
    $controller = new AdsController($ads_gateway);

    $controller->processRequest($method, $id);
}

elseif ($resource === "login") {

    require __DIR__."/login.php";
}

else  {

    http_response_code(404);
    exit();

}