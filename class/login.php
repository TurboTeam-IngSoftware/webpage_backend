<?php
header('Content-Type: text/html; charset=UTF-8');

require_once "connection/connection.php";
require_once "response.php";

class Login extends connection {

    public function userLogin($jsonBody) {
        $_response = new response;
        $data = json_decode($jsonBody, true);
        if (!isset($data["email"]) || !isset($data["password"])) {
            return $_response->error_400();
        } else {
            $email = $data["email"];
            $password = $data["password"];
            $query = "SELECT * FROM users WHERE email LIKE '$email' AND password LIKE '$password'";
            $data = parent::getData($query);
            
            if ($data) {
                return $data;
            } else {
                return $_response->error_request("User does not exist or credentials are incorrect");
            }
        }
    }
}

?>