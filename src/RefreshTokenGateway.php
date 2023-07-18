<?php

use Buki\Pdox;

class RefreshTokenGateway {

    private Pdox $conn;


    public function __construct(Database $database,private string $key){
        $this->conn = $database->getConnection();
    }

    public function create(string $token, int $expiry): int
    {
        $hash = hash_hmac("sha256", $token, $this->key);


        $data = [
            "token_hash" => $hash ,
            'expires_at' => date("Y-m-d H:i:s", $expiry)
        ];

        return $this->conn->table("refresh_token")->insert($data);


    }

    public function delete(string $token): int
    {

        $hash = hash_hmac("sha256", $token, $this->key);

        return $this->conn->table("refresh_token")->where("token_hash", $hash)->delete();
    }

    public function getByToken(string $token): array
    {
        $hash = hash_hmac("sha256", $token, $this->key);


        return (array) $this->conn->table('refresh_token')->where("token_hash", $hash)->get();
    }

    public function deleteExpired(): int
    {
        return $this->conn
            ->table("refresh_token")
            ->where("expires_at","<",date("Y-m-d H:i:s"))
            ->delete();
    }
}