<?php


use Buki\Pdox;

class AdsGateway
{

    private Pdox $conn;


    public function __construct(Database $database)
    {

        $this->conn = $database->getConnection();

    }

    public function getAds(): array
    {
        return $this->conn->table("advertisements")->getAll();
    }

    public function createAd(array $data): int
    {

        return $this->conn->table("advertisements")->insert($data);

    }

    public function getAd(int $id): array|object
    {

        return $this->conn->table("advertisements")->where(["id" => $id])->get();

    }

    public function deleteAd(int $id): int
    {

        return $this->conn->table("advertisements")->where(["id" => $id])->delete();

    }

    public function updateAd(int $id, array $data): int
    {
        $data["updated_at"] = date('Y-m-d H:i:s');
        return $this->conn->table("advertisements")->where(["id" => $id])->update($data);
    }


}