
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
        $dataPhotosRelation = $_photosRelation->getphotosRelation($idRelation);
        $optionUrl->resDataGet($dataPhotosRelation);
    }else{
        $dataPhotosRelation = $_photosRelation->listphotosRelation();
        $optionUrl->resDataGet($dataPhotosRelation);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "PhotosRelation") {
    $photosRelationBody=$optionUrl->getDataURL();
    $dataArray = $_photosRelation->store($photosRelationBody);
    $optionUrl->resDataPhotosRelation($dataArray);
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