<?php

require dirname(__DIR__) . "/utilities.php";;
class AdsController
{


    public function __construct(private AdsGateway $gateway, private Authorization $authorization)
    {
    }

    public function processRequest(string $method, ?string $id): void
    {

        if ($id === null) {

            if ($method == 'GET') {

                echo json_encode($this->gateway->getAds());
            } elseif ($method == "POST") {


                if (
                    !$this->authorization->is_admin() AND
                    !$this->authorization->is_seller()
                ) {
                    $this->respondUnauthorized();
                    return;
                }

                $data = (array) json_decode(file_get_contents('php://input'), true);

                $errors = $this->getValidationErrors($data);

                if (!empty($errors)) {

                    $this->respondUnprocessableEntity($errors);
                    return;
                }

                $id = $this->gateway->createAd($data);
                $this->respondCreated($id);
            } else {
                $this->methodNotAllowed("GET, POST");
            }
        } else {

            if (
                !$this->authorization->is_admin() AND
                !$this->authorization->is_seller() AND $method !== "GET"
            ) {
                $this->respondUnauthorized();
                return;
            }

            $estate = $this->gateway->getAd($id);

            if (empty($estate)) {
                $this->respondNotFound($id);
                return;
            }


            switch ($method) {
                case "GET":
                    echo json_encode($estate);
                    break;

                case "PATCH":
                    $data = (array) json_decode(file_get_contents('php://input'), true);
                    $rows = $this->gateway->updateAd($id, $data);
                    echo json_encode(["message" => "Estate updated", "rows" => $rows]);
                    break;

                case "DELETE":
                    $rows = $this->gateway->deleteAd($id);
                    echo json_encode(["message" => "Estate deleted", "rows" => $rows]);
                    break;
                default:
                    $this->methodNotAllowed("GET, PUT, DELETE");
                    break;
            }
        }
    }

    private function methodNotAllowed(string $allowedMethods): void
    {
        http_response_code(405);
        header('Allow: ' . $allowedMethods);
    }

    private function respondUnauthorized(): void
    {
        http_response_code(401);
        echo json_encode(["message" => "Unauthorized"]);
    }

    private function respondCreated(string $id): void
    {
        http_response_code(201);
        echo json_encode(["message" => "Advertisement created", "id" => $id]);
    }

    private function respondUnprocessableEntity(array $errors): void
    {
        http_response_code(422);
        echo json_encode(["errors" => $errors]);
    }

    private function respondNotFound(string $id): void
    {
        http_response_code(404);
        echo json_encode(["message" => "Advertisement with ID $id not found"]);
    }

    private function getValidationErrors(array $data): array
    {

        $errors = [];

        if (!array_key_exists("title", $data)) {
            $errors[] = "title is required";
        }

        if (!array_key_exists("city_id", $data)) {
            $errors[] = "city_id is required";
        }

        if (!array_key_exists("address", $data)) {
            $errors[] = "address is required";
        }

        if (!array_key_exists("meters", $data)) {
            $errors[] = "meters is required";
        }


        if (!array_key_exists("year", $data)) {
            $errors[] = "year is required";
        }

        if (!array_key_exists("rooms", $data)) {
            $errors[] = "rooms is required";
        }

        if (!array_key_exists("floor", $data)) {
            $errors[] = "floor is required";
        }

        if (!array_key_exists("price", $data)) {
            $errors[] = "price is required";
        }

        if (!array_key_exists("descriptions", $data)) {
            $errors[] = "descriptions is required";
        }



        foreach ($data as $key => $value) {
            $data[$key] = input_cleaner($value);
        }

        return $errors;
    }
}
