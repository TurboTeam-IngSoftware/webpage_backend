<?php

require_once "connection/connection.php";
require_once "response.php";

class PhotosRelation extends connection {

    private $table = "photosRelation";
    private $idPost="";
    private $idPhoto="";
    private $idRelation="";

    public function listPhotosRelation() {
        $query = "SELECT * FROM " . $this->table;
        return parent::getData($query);
    }

    public function getPhotoRelation($idRelation) {
        $query = "SELECT * FROM " . $this->table . " WHERE idRelation = '$idRelation'";
        return parent::getData($query);
    }

    public function store($json){
        $_response= new response();
        $data = json_decode($json,true);
        if (!isset($data['idPost'])||!isset($data['idPhoto'])){
            return $_response->error_400();
        }else{
            $this->date=$data['idPost'];
            $this->idPhoto=$data['idPhoto'];

            $save=$this->saveData();

            if ($save){
                $response=$_response->response;
                $response["result"]=array(
                    "idPost"=>$save
                );
                return $response;
            }else{return $_response->error_500();}
        }
    }

    public function update($json){
        $_response=new response();
        $data=json_decode($json,true);
        if (!isset($data['idRelation'])){
            return $_response->error_400();
        }else{
            $this->idRelation=$data['idRelation'];
            if (isset($data['idPhoto']))$this->idPhoto=$data['idPhoto'];
            if (isset($data['idPost']))$this->idRelation=$data['idPost'];
            $update=$this->updateData();
            if ($update){
                $response=$_response->response;
                $response['result']=array(
                    "idRelation"=>$this->idRelation
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
        if (!isset($data['idRelation'])){
            return $_response->error_400();
        }else{
            $this->idRelation=$data['idRelation'];
            $destroy=$this->deleteData();
            if ($destroy){
                $response=$_response->response;
                $response['result']=array(
                    "idRelation"=>$this->idRelation
                );
                return $response;
            }else{
                return $_response->error_500();
            }
        }
    }

    private function saveData(){
        $query ="INSERT INTO ".$this->table." (idPost,idPhoto)values('".$this->idPost."','".$this->idPhoto."')";
        $save = parent::nonQueryId($query);
        if ($save)return $save;
        else return 0;

    }
    private function updateData(){
        $query="UPDATE ".$this->table." SET idPost='".$this->idPost."', idPhoto='".$this->idPhoto."' WHERE idRelation='".$this->idRelation."'";
        $update=parent::nonQuery($query);
        if ($update>=1)return $update;
        else return 0;
    }
    private function deleteData(){
        $query="DELETE FROM ".$this->table." WHERE idRelation='".$this->idRelation."'";
        $destroy=parent::nonQuery($query);
        if ($destroy >=1)return $destroy;
        else return 0;
    }
}

?>