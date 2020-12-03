
<?php

require_once "class/response.php";
require_once "class/photosRelation.php";
require_once "class/optionUrl.php";

$_response = new response;
$_photosRelation = new PhotosRelation;
$optionUrl = new optionUrl;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_GET["id"])){
        $idRelation = $_GET['id'];
        $dataPhotosRelation = $_photosRelation->getPhotoRelation($idRelation);
        $optionUrl->resDataGet($dataPhotosRelation);
    }else{
        $dataPhotosRelation = $_photosRelation->listPhotosRelation();
        $optionUrl->resDataGet($dataPhotosRelation);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postBody = file_get_contents("php://input");
    $data = $_photosRelation->store($postBody);

    header('Content-Type: application/json');
    if(isset($data["result"]["error_id"])) {
        $responseCode = $data["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($data);
} else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $photosRelationBody=$optionUrl->getDataURL();
    $dataArray=$_photosRelation->update($photosRelationBody);
    $optionUrl->resDataPhotosRelation($dataArray);
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $photosRelationBody=$optionUrl->getDataURL();
    $dataArray = $_photosRelation->delete($photosRelationBody);
    $optionUrl->resDataPhotosRelation($dataArray);
} else {
    $optionUrl->reqUnk();
}

?>