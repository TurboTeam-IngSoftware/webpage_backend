<?php
header('Content-Type: text/html; charset=UTF-8');

require_once 'class/login.php';
require_once 'class/response.php';

$_user = new Login;
$_response = new response;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postBody = file_get_contents("php://input");
    $data = $_user->userLogin($postBody);
    header('Content-Type: application/json');
    if(isset($data["result"]["error_id"])) {
        $responseCode = $data["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($data);
} else {
    header('Content-Type: application/json');
    http_response_code(405);
    $data = $_response->error_405();
    echo json_encode($data);
}
?>