<?php

use Buki\Pdox;

class UserGateway
{
    private Pdox $conn;

    public function __construct(Database $database){

        $this->conn = $database->getConnection();

    }


    public function getByID(int $id): array{
        return (array) $this->conn->table("users")->where("id", $id)->get();
    }

    public function getByEmail(string $email) : array {
        return (array) $this->conn->table("users")->where("email", $email)->get();

    }

    public function create(array $data) : int {

        $data["role_id"] = 3; 
        $data["password"] = hash_hmac("sha256", $data["password"],$_ENV["SECRET_KEY"]);
        return $this->conn->table("users")->insert($data);

    }



}