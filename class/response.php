<?php

class response {

    public $response = [
        "status" => "ok",
        "result" => array()
    ];

    public function error_405() {
        $this->response["status"] = "error";
        $this->response["result"] = array(
            "error_id" => "405",
            "error_msg" => "Method not allowed"
        );
        return $this->response;
    }

    public function error_request($message = 'Incorrect information') {
        $this->response["status"] = "error";
        $this->response["result"] = array(
            "error_id" => "200",
            "error_msg" => $message
        );
        return $this->response;
    }

    public function error_400() {
        $this->response["status"] = "error";
        $this->response["result"] = array(
            "error_id" => "400",
            "error_msg" => "Wrong data"
        );
        return $this->response;
    }

    public function error_500($message = "Internal Server Error") {
        $this->response["status"] = "error";
        $this->response["result"] = array(
            "error_id" => "500",
            "error_msg" => $message
        );
        return $this->response;
    }

}

?>