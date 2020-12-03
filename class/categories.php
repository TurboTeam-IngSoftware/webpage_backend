<?php

require_once "connection/connection.php";
require_once "response.php";

class Categories extends connection {

    private $table = "categories";
    private $idCategory="";
    private $category="";

    public function listCategories() {
        $query = "SELECT * FROM " . $this->table;
        return parent::getData($query);
    }

    public function getCategory($idCategory) {
        $query = "SELECT * FROM " . $this->table . " WHERE idCategory = '$idCategory'";
        return parent::getData($query);
    }

    public function store($json){
        $_response= new response();
        $data = json_decode($json,true);
        if (!isset($data['category'])){
            return $_response->error_400();
        }else{
            $this->category=$data['category'];

            $save=$this->saveData();

            if ($save){
                $response=$_response->response;
                $response["result"]=array(
                    "idCategory"=>$save
                );
                return $response;
            }else{return $_response->error_500();}
        }
    }

    public function update($json){
        $_response=new response();
        $data=json_decode($json,true);
        if (!isset($data['idCategory'])){
            return $_response->error_400();
        }else{
            $this->idCategory=$data['idCategory'];
            if (isset($data['category']))$this->category=$data['category'];
            $update=$this->updateData();
            if ($update){
                $response=$_response->response;
                $response['result']=array(
                    "idCategory"=>$this->idCategory
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
        if (!isset($data['idCategory'])){
            return $_response->error_400();
        }else{
            $this->idCategory=$data['idCategory'];
            $destroy=$this->deleteData();
            if ($destroy){
                $response=$_response->response;
                $response['result']=array(
                    "idCategory"=>$this->idCategory
                );
                return $response;
            }else{
                return $_response->error_500();
            }
        }
    }

    private function saveData(){
        $query ="INSERT INTO ".$this->table." (category)values('".$this->category."')";
        $save = parent::nonQueryId($query);
        if ($save)return $save;
        else return 0;

    }
    private function updateData(){
        $query="category='".$this->category."' WHERE idCategory='".$this->idCategory."'";
        $update=parent::nonQuery($query);
        if ($update>=1)return $update;
        else return 0;
    }
    private function deleteData(){
        $query="DELETE FROM ".$this->table." WHERE idCategory='".$this->idCategory."'";
        $destroy=parent::nonQuery($query);
        if ($destroy >=1)return $destroy;
        else return 0;
    }
}

?>