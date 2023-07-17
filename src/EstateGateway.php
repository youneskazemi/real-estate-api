<?php


use Buki\Pdox;

class EstateGateway
{

    private Pdox $conn;


    public function __construct(Database $database)
    {

        $this->conn = $database->getConnection();

    }

    public function getAllEstates(): array
    {
        return $this->conn->table("estates")->getAll();
    }

    public function addEstate(array $data): int
    {

        $this->conn->table("estates")->insert($data);

        return $this->conn->insertId();

    }

    public function getEstate(int $id): array|object
    {

        return $this->conn->table("estates")->where(["id" => $id])->get();

    }

    public function deleteEstate(int $id): int
    {

        return $this->conn->table("estates")->where(["id" => $id])->delete();

    }

    public function updateEstate(int $id, array $data): int
    {
        $data["updated_at"] = date('Y-m-d H:i:s');
        return $this->conn->table("estates")->where(["id" => $id])->update($data);
    }


}