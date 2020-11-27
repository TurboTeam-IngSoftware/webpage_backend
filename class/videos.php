<?php

require_once "connection/connection.php";
require_once "response.php";

class Videos extends connection {

    private $table = "videos";
    private $idVideo="";
    private $resourceURL="";

    public function listVideos() {
        $query = "SELECT * FROM " . $this->table;
        return parent::getData($query);
    }

    public function getPost($idVideo) {
        $query = "SELECT * FROM " . $this->table . " WHERE idVideo = '$idVideo'";
        return parent::getData($query);
    }

    public function store($json){
        $_response= new response();
        $data = json_decode($json,true);
        if (!isset($data['resourceURL'])){
            return $_response->error_400();
        }else{
            $this->resourceURL=$data['resourceURL'];

            $save=$this->saveData();

            if ($save){
                $response=$_response->response;
                $response["result"]=array(
                    "idVideo"=>$save
                );
                return $response;
            }else{return $_response->error_500();}
        }
    }

    public function update($json){
        $_response=new response();
        $data=json_decode($json,true);
        if (!isset($data['idVideo'])){
            return $_response->error_400();
        }else{
            $this->idVideo=$data['idVideo'];
            if (isset($data['resourceURL']))$this->resourceURL=$data['resourceURL'];
            $update=$this->updateData();
            if ($update){
                $response=$_response->response;
                $response['result']=array(
                    "idVideo"=>$this->idVideo
                );
                return $response;
            }else{
                return $_response->error_500();
            }
        }
    }

    public function delete($json){
        $_response = new response();
        $data=json_decode($json,true);
        if (!isset($data['idVideo'])){
            return $_response->error_400();
        }else{
            $this->idVideo=$data['idVideo'];
            $destroy=$this->deleteData();
            if ($destroy){
                $response=$_response->response;
                $response['result']=array(
                    "idVideo"=>$this->idVideo
                );
                return $response;
            }else{
                return $_response->error_500();
            }
        }
    }

    private function saveData(){
        $query ="INSERT INTO ".$this->table." (resourceURL)values('".$this->resourceURL."')";
        $save = parent::nonQueryidVideo($query);
        if ($save)return $save;
        else return 0;

    }
    private function updateData(){
        $query="update ".$this->table." SET resourceURL='".$this->resourceURL."' WHERE idVideo='".$this->idVideo."'";
        $update=parent::nonQuery($query);
        if ($update>=1)return $update;
        else return 0;
    }
    private function deleteData(){
        $query="DELETE FROM ".$this->table." WHERE idVideo='".$this->idVideo."'";
        $destroy=parent::nonQuery($query);
        if ($destroy >=1)return $destroy;
        else return 0;
    }
}

?>