<?php


require __DIR__."/bootstrap.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST"){
    http_response_code(405);
    header("Allow: POST");
    exit();
}

$data = (array) json_decode(file_get_contents("php://input"), true);

if (!array_key_exists("full_name", $data) ||
    !array_key_exists("email", $data) ||
    !array_key_exists("password", $data) ||
    !array_key_exists("national_id", $data)){
    http_response_code(400);
    echo json_encode(["message" => "please fill all required fields"]);
    exit;
}

$database = new Database(
    $_ENV['DB_HOST'],
    $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $options ?? null
);

$user_gateway = new UserGateway($database);

$user_gateway->create($data);