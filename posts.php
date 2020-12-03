
<?php

require_once "class/response.php";
require_once "class/posts.php";
require_once "class/optionUrl.php";

$_response = new response;
$_posts = new Posts;
$optionUrl = new optionUrl;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_GET["id"])){
        $idPost = $_GET['id'];
        $dataPosts = $_posts->getPost($idPost);
        $optionUrl->resDataGet($dataPosts);
    }else {
        $dataPosts = $_posts->listPosts();
        $optionUrl->resDataGet($dataPosts);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postBody = file_get_contents("php://input");
    $data = $_posts->store($postBody);

    header('Content-Type: application/json');
    if(isset($data["result"]["error_id"])) {
        $responseCode = $data["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($data);

} else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $postBody=$optionUrl->getDataURL();
    $dataArray=$_posts->update($postBody);
    $optionUrl->resDataPOST($dataArray);
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $postBody=$optionUrl->getDataURL();
    $dataArray = $_posts->delete($postBody);
    $optionUrl->resDataPOST($dataArray);
} else {
    $optionUrl->reqUnk();
}

?>