
<?php

require_once "class/response.php";
require_once "class/videosRelation.php";
require_once "class/optionUrl.php";

$_response = new response;
$_videosRelation = new VideosRelation;
$optionUrl = new optionUrl;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_GET["id"])){
        $idRelation = $_GET['id'];
        $dataVideosRelation = $_videosRelation->getVideosRelation($idRelation);
        $optionUrl->resDataGet($dataVideosRelation);
    }else{
        $dataVideosRelation = $_videosRelation->listVideosRelation();
        $optionUrl->resDataGet($dataVideosRelation);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "videosRelation") {
    $videosRelationBody=$optionUrl->getDataURL();
    $dataArray = $_videosRelation->store($videosRelationBody);
    $optionUrl->resDataVideosRelation($dataArray);
} else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $videosRelationBody=$optionUrl->getDataURL();
    $dataArray=$_videosRelation->update($videosRelationBody);
    $optionUrl->resDataVideosRelation($dataArray);
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $videosRelationBody=$optionUrl->getDataURL();
    $dataArray = $_videosRelation->delete($videosRelationBody);
    $optionUrl->resDataVideosRelation($dataArray);
} else {
    $optionUrl->reqUnk();
}

?>