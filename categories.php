
<?php

require_once "class/response.php";
require_once "class/categories.php";
require_once "class/optionUrl.php";

$_response = new response;
$_categories = new Categories;
$optionUrl = new optionUrl;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_GET["id"])){ //$_GET["page"] verefica si existe una variable en el url
        $idCategories = $_GET['id'];
        $dataCategories = $_categories->getCategory($idCategories);
        $optionUrl->resDataGet($dataCategories);
    }else {
        $dataCategories = $_categories->listCategories();
        $optionUrl->resDataGet($dataCategories);
    }
}

?>