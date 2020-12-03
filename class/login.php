<?php

require_once "connection/connection.php";
require_once "response.php";

class Login extends connection {

    public function login($jsonBody) {
        $_response = new response;
        $data = json_decode($jsonBody, true);
        if (!isset($data["email"]) || !isset($data["password"])) {
            // Error falta datos para la autenticación
            return $_response->error_400();
        } else {
            $email = $data["email"];
            $password = $data["password"];

            $data = $this->getUserData($email, $password);
            if ($data) {
                return 200;
            } else {
                // No se encontró un usuario
                return $_response->error_request("User does not exist or credentials are incorrect");
            }
        }
    }

    private function getUserData($email, $password) {
        // Obtener cliente con número de telefono y password
        $query = "SELECT * FROM clientes WHERE email LIKE '$email' AND password LIKE '$password'";
        $data = parent::getData($query);
        if (isset($data[0]["idUser"])) {
            return $data;
        } else {
            return 0;
        }
    }
}

?>