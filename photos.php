
<?php

require_once "class/response.php";
require_once "class/photos.php";
require_once "class/optionUrl.php";

$_response = new response;
$_photos = new Photos;
$optionUrl = new optionUrl;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_GET["id"])){ //$_GET["page"] verefica si existe una variable en el url
        $idPhoto = $_GET['id'];
        $dataPhoto = $_photos->getPhotos($idPhoto);
        $optionUrl->resDataGet($dataPhoto);
    }else {
        $dataPhoto = $_photos->listPhotos();
        $optionUrl->resDataGet($dataPhoto);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postBody = file_get_contents("php://input");
    $data = $_photos->store($postBody);

    header('Content-Type: application/json');
    if(isset($data["result"]["error_id"])) {
        $responseCode = $data["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($data);
} else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $photoBody=$optionUrl->getDataURL();
    $dataArray=$_photos->update($photoBody);
    $optionUrl->resDataPOST($dataArray);
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $photoBody=$optionUrl->getDataURL();
    $dataArray = $_photos->delete($photoBody);
    $optionUrl->resDataPOST($dataArray);
} else {
    $optionUrl->reqUnk();
}

?>