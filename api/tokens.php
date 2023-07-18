<?php

$payload = [
    "sub" => $user["id"],
    "email" => $user["email"],
    "role" => $user["role_id"],
    "exp" => time() + 300
];

$access_token = $codec->encode($payload);

$refresh_token_expiry = time() + 432000;

$refresh_token = $codec->encode([
    "sub" => $user["id"],
    "email" => $user["email"],
    "role" => $user["role_id"],
    "exp" => $refresh_token_expiry
]);

echo json_encode([
    "access_token" => $access_token,
    "refresh_token" => $refresh_token
]);