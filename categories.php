<?php
header('Content-Type: text/html; charset=UTF-8');

require_once "class/response.php";
require_once "class/categories.php";
require_once "class/optionUrl.php";

$_response = new response;
$_categories = new Categories;
$optionUrl = new optionUrl;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_GET["id"])){
        $idCategories = $_GET['id'];
        $dataCategories = $_categories->getCategory($idCategories);
        $optionUrl->resDataGet($dataCategories);
    }else {
        $dataCategories = $_categories->listCategories();
        $optionUrl->resDataGet($dataCategories);
    }
}

?>