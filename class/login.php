<?php

require_once "connection/connection.php";
require_once "response.php";

class Login extends connection {

    public function userLogin($jsonBody) {
        $_response = new response;
        $data = json_decode($jsonBody, true);
        if (!isset($data["email"]) || !isset($data["password"])) {
            // Error falta datos para la autenticación
            return $_response->error_400();
        } else {
            $email = $data["email"];
            $password = $data["password"];
            $query = "SELECT * FROM users WHERE email LIKE '$email' AND password LIKE '$password'";
            $data = parent::getData($query);
            
            if ($data) {
                // Se encontró el usuario
                return $data;
            } else {
                // No se encontró un usuario
                return $_response->error_request("User does not exist or credentials are incorrect");
            }
        }
    }
}

?>