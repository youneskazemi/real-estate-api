<?php


class EstateController
{

    public function processRequest(string $method, ?string $id): void
    {

        if ($id === null) {

            if ($method == 'GET') {

                echo "show all Ads";

            } elseif ($method == "POST") {

                echo "create Ad";
            } else {
                $this->methodNotAllowed("GET, POST");
            }

        } else {

            switch ($method) {
                case "GET":
                    echo "show one Ad with id = " . $id;
                    break;

                case "PUT":
                    echo "update Ad with id = " . $id;
                    break;

                case "DELETE":
                    echo "delete Ad with id = " . $id;
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


}