<?php

require_once "class/response.php";


class optionUrl
{

    function getDataURL(){
        return file_get_contents("php://input");
    }
    function resDataGet($data){
        header('content-Type: application/json');
        echo json_encode($data);
        http_response_code(200);
    }
    function resDataPOST($dataArray){
        header('content-Type:application/json');
        if (isset($dataArray['result']['error_id'])){
            $responseCode=$dataArray['result']['error_id'];
            http_response_code($responseCode);
        }else{
            http_response_code(200);
        }
        echo json_encode($dataArray);
    }
    function reqUnk(){
        $_response = new response();
        header('Content-Type: application/json');
        http_response_code(405);
        $data = $_response->error_405();
        echo json_encode($data);
    }
}