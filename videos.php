
<?php

require_once "class/response.php";
require_once "class/videos.php";
require_once "class/optionUrl.php";

$_response = new response;
$_videos = new Videos;
$optionUrl = new optionUrl;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_GET["id"])){ //$_GET["page"] verefica si existe una variable en el url
        $idPost = $_GET['id'];
        $videoPhoto = $_videos->getvideos($idPost);
        $optionUrl->resDataGet($videoPhoto);
    }else {
        $videoPhoto = $_videos->listvideos();
        $optionUrl->resDataGet($videoPhoto);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $videoBody=$optionUrl->getDataURL();
    $dataArray = $_videos->store($videoBody);
    $optionUrl->resDataPOST($dataArray);
} else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $videoBody=$optionUrl->getDataURL();
    $dataArray=$_videos->update($videoBody);
    $optionUrl->resDataPOST($dataArray);
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $videoBody=$optionUrl->getDataURL();
    $dataArray = $_videos->delete($videoBody);
    $optionUrl->resDataPOST($dataArray);
} else {
    $optionUrl->reqUnk();
}

?>