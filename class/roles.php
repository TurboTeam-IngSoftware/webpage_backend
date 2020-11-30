<?php

require_once "connection/connection.php";
require_once "response.php";

class Roles extends connection {

    private $table = "roles";
    private $idRole="";
    private $writePer="";
    private $revisionPer="";
    private $addUserPer="";

    public function listRoles() {
        $query = "SELECT * FROM " . $this->table;
        return parent::getData($query);
    }

    public function getRole($idRole) {
        $query = "SELECT * FROM " . $this->table . " WHERE idRole = '$idRole'";
        return parent::getData($query);
    }

    public function store($json){
        $_response= new response();
        $data = json_decode($json,true);
        if (!isset($data['writePer'])||!isset($data['revisionPer'])||!isset($data['addUserPer'])){
            return $_response->error_400();
        }else{
            $this->writePer=$data['writePer'];
            $this->revisionPer=$data['revisionPer'];
            $this->addUserPer=$data['addUserPer'];

            $save=$this->saveData();

            if ($save){
                $response=$_response->response;
                $response["result"]=array(
                    "idRole"=>$save
                );
                return $response;
            }else{return $_response->error_500();}
        }
    }

    public function update($json){
        $_response=new response();
        $data=json_decode($json,true);
        if (!isset($data['idRole'])){
            return $_response->error_400();
        }else{
            $this->idRole=$data['idRole'];
            if (isset($data['writePer']))$this->writePer=$data['writePer'];
            if (isset($data['revisionPer']))$this->revisionPer=$data['revisionPer'];
            if (isset($data['addUserPer']))$this->addUserPer=$data['addUserPer'];
            $update=$this->updateData();
            if ($update){
                $response=$_response->response;
                $response['result']=array(
                    "idRole"=>$this->idRole
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
        if (!isset($data['idRole'])){
            return $_response->error_400();
        }else{
            $this->idRole=$data['idRole'];
            $destroy=$this->deleteData();
            if ($destroy){
                $response=$_response->response;
                $response['result']=array(
                    "idRole"=>$this->idRole
                );
                return $response;
            }else{
                return $_response->error_500();
            }
        }
    }

    private function saveData(){
        $query ="INSERT INTO ".$this->table." (writePer,revisionPer,addUserPer)values('".$this->writePer."','".$this->revisionPer."','".$this->addUserPer."')";
        $save = parent::nonQueryidRole($query);
        if ($save)return $save;
        else return 0;

    }
    private function updateData(){
        $query="UPDATE ".$this->table." SET writePer='".$this->writePer."', revisionPer='".$this->revisionPer."', addUserPer='".$this->addUserPer."' WHERE idRole='".$this->idRole."'";
        $update=parent::nonQuery($query);
        if ($update>=1)return $update;
        else return 0;
    }
    private function deleteData(){
        $query="DELETE FROM ".$this->table." WHERE idRole='".$this->idRole."'";
        $destroy=parent::nonQuery($query);
        if ($destroy >=1)return $destroy;
        else return 0;
    }
}

?>