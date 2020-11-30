<?php

require_once "connection/connection.php";
require_once "response.php";

class Users extends connection {

    private $table = "users";
    private $idUser="";
    private $email="";
    private $names="";
    private $lastnames="";
    private $password="";
    private $roles="";

    public function listUsers() {
        $query = "SELECT * FROM " . $this->table;
        return parent::getData($query);
    }

    public function getUser($idUser) {
        $query = "SELECT * FROM " . $this->table . " WHERE idUser = '$idUser'";
        return parent::getData($query);
    }

    public function store($json){
        $_response= new response();
        $data = json_decode($json,true);
        if (!isset($data['email'])||!isset($data['names'])||!isset($data['lastnames'])||!isset($data['password'])||!isset($data['roles'])){
            return $_response->error_400();
        }else{
            $this->email=$data['email'];
            $this->names=$data['names'];
            $this->lastnames=$data['lastnames'];
            $this->password=$data['password'];
            $this->roles=$data['roles'];

            $save=$this->saveData();

            if ($save){
                $response=$_response->response;
                $response["result"]=array(
                    "idUser"=>$save
                );
                return $response;
            }else{return $_response->error_500();}
        }
    }

    public function update($json){
        $_response=new response();
        $data=json_decode($json,true);
        if (!isset($data['idUser'])){
            return $_response->error_400();
        }else{
            $this->idUser=$data['idUser'];
            if (isset($data['email']))$this->email=$data['email'];
            if (isset($data['names']))$this->names=$data['names'];
            if (isset($data['lastnames']))$this->lastnames=$data['lastnames'];
            if (isset($data['password']))$this->password=$data['password'];
            if (isset($data['roles']))$this->roles=$data['roles'];
            $uplastnames=$this->uplastnamesData();
            if ($uplastnames){
                $response=$_response->response;
                $response['result']=array(
                    "idUser"=>$this->idUser
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
        if (!isset($data['idUser'])){
            return $_response->error_400();
        }else{
            $this->idUser=$data['idUser'];
            $destroy=$this->deleteData();
            if ($destroy){
                $response=$_response->response;
                $response['result']=array(
                    "idUser"=>$this->idUser
                );
                return $response;
            }else{
                return $_response->error_500();
            }
        }
    }

    private function saveData(){
        $query ="INSERT INTO ".$this->table." (email,names,lastnames,password,roles)values('".$this->email."','".$this->names."','".$this->lastnames."','".$this->password."','".$this->roles."')";
        $save = parent::nonQueryidUser($query);
        if ($save)return $save;
        else return 0;

    }
    private function updateData(){
        $query="UPDATE ".$this->table." SET email='".$this->email."', names='".$this->names."', lastnames='".$this->lastnames."', password='".$this->password."', roles= '".$this->roles."' WHERE idUser='".$this->idUser."'";
        $update=parent::nonQuery($query);
        if ($update>=1)return $update;
        else return 0;
    }
    private function deleteData(){
        $query="DELETE FROM ".$this->table." WHERE idUser='".$this->idUser."'";
        $destroy=parent::nonQuery($query);
        if ($destroy >=1)return $destroy;
        else return 0;
    }
}

?>