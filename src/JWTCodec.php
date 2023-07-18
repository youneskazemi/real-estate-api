<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class JWTCodec {

    public function __construct(private string $key)
    {
    }


    public function encode(array $payload): string
    {
        return JWT::encode($payload, $this->key, 'HS256');
    }

    public function decode(string $jwt): array
    {
        return (array) JWT::decode($jwt, new Key($this->key, 'HS256'));
    }

}