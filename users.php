
<?php

require_once "class/response.php";
require_once "class/users.php";
require_once "class/optionUrl.php";

$_response = new response;
$_users = new Users;
$optionUrl = new optionUrl;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_GET["id"])){
        $idUser = $_GET['id'];
        $dataUsers = $_users->getUser($idUser);
        $optionUrl->resDataGet($dataUsers);
    }else {
        $dataUsers = $_users->listUsers();
        $optionUrl->resDataGet($dataUsers);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userBody=$optionUrl->getDataURL();
    $postBody = file_get_contents("php://input");
    $data = $_users->store($postBody);

    header('Content-Type: application/json');
    if(isset($data["result"]["error_id"])) {
        $responseCode = $data["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($data);
} else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $userBody=$optionUrl->getDataURL();
    $putBody = file_get_contents("php://input");
    $dataArray=$_users->update($putBody);
    $optionUrl->resDataPOST($dataArray);
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $userBody=$optionUrl->getDataURL();
    $dataArray = $_users->delete($userBody);
    $optionUrl->resDataPOST($dataArray);
} else {
    $optionUrl->reqUnk();
}

?>