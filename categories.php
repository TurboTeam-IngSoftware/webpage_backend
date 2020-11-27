
<?php

require_once "class/response.php";
require_once "class/categories.php";
require_once "class/optionUrl.php";

$_response = new response;
$_categories = new Categories;
$optionUrl = new optionUrl;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_GET["id"])){ //$_GET["page"] verefica si existe una variable en el url
        $idPost = $_GET['id'];
        $dataCategories = $_categories->getCategories($idPost);
        $optionUrl->resDataGet($dataCategories);
    }else {
        $dataCategories = $_categories->listCategories();
        $optionUrl->resDataGet($dataCategories);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryBody=$optionUrl->getDataURL();
    $dataArray = $_categories->store($categoryBody);
    $optionUrl->resDataPOST($dataArray);
} else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $categoryBody=$optionUrl->getDataURL();
    $dataArray=$_categories->update($categoryBody);
    $optionUrl->resDataPOST($dataArray);
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $categoryBody=$optionUrl->getDataURL();
    $dataArray = $_categories->delete($categoryBody);
    $optionUrl->resDataPOST($dataArray);
} else {
    $optionUrl->reqUnk();
}

?>