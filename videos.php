
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
    $postBody = file_get_contents("php://input");
    $data = $_videos->store($postBody);

    header('Content-Type: application/json');
    if(isset($data["result"]["error_id"])) {
        $responseCode = $data["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($data);
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