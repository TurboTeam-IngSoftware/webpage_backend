
<?php

require_once "class/response.php";
require_once "class/roles.php";
require_once "class/optionUrl.php";

$_response = new response;
$_roles = new Roles;
$optionUrl = new optionUrl;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_GET["id"])){ //$_GET["page"] verefica si existe una variable en el url
        $idRole = $_GET['id'];
        $dataRole = $_roles->getRole($idRole);
        $optionUrl->resDataGet($dataRole);
    }else {
        $dataRole = $_roles->listRoles();
        $optionUrl->resDataGet($dataRole);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postBody = file_get_contents("php://input");
    $data = $_roles->store($postBody);

    header('Content-Type: application/json');
    if(isset($data["result"]["error_id"])) {
        $responseCode = $data["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($data);
} else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $RoleBody=$optionUrl->getDataURL();
    $dataArray=$_roles->update($RoleBody);
    $optionUrl->resDataPOST($dataArray);
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $RoleBody=$optionUrl->getDataURL();
    $dataArray = $_roles->delete($RoleBody);
    $optionUrl->resDataPOST($dataArray);
} else {
    $optionUrl->reqUnk();
}

?>