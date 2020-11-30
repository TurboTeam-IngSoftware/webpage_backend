
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
        $dataRole = $_roles->getRoles($idRole);
        $optionUrl->resDataGet($dataRole);
    }else {
        $dataRole = $_roles->listRoles();
        $optionUrl->resDataGet($dataRole);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $RoleBody=$optionUrl->getDataURL();
    $dataArray = $_roles->store($RoleBody);
    $optionUrl->resDataPOST($dataArray);
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