<?php


require __DIR__."/bootstrap.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST"){
    http_response_code(405);
    header("Allow: POST");
    exit();
}

$data = (array) json_decode(file_get_contents("php://input"), true);

if (!array_key_exists("email", $data) ||
    !array_key_exists("password", $data)){
    http_response_code(400);
    echo json_encode(["message" => "missing login credentials"]);
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

$user = $user_gateway->getByEmail($data["email"]);

if (empty($user)){
    http_response_code(401);
    echo json_encode(["message" => "invalid authentication"]);
    exit;
}

if (hash_hmac("sha256",$data["password"],$_ENV["SECRET_KEY"]) !== $user["password"]) {

    http_response_code(401);
    echo json_encode(["message" => "invalid authentication"]);
    exit;
}


$codec = new JWTCodec($_ENV["SECRET_KEY"]);

require __DIR__."/tokens.php";

$refresh_token_gateway = new RefreshTokenGateway($database, $_ENV["SECRET_KEY"]);

$refresh_token_gateway->create($refresh_token, $refresh_token_expiry);
