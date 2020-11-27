<?php

require_once "connection/connection.php";
require_once "response.php";

class Posts extends connection {

    private $table = "posts";
    private $idPost="";
    private $title="";
    private $shortDescription="";
    private $date="";
    private $category="";

    public function listPosts() {
        $query = "SELECT * FROM " . $this->table;
        return parent::getData($query);
    }

    public function getPost($idPost) {
        $query = "SELECT * FROM " . $this->table . " WHERE idPost = '$idPost'";
        return parent::getData($query);
    }

    public function store($json){
        $_response= new response();
        $data = json_decode($json,true);
        if (!isset($data['title'])||!isset($data['shortDescription'])||!isset($data['date'])||!isset($data['category'])){
            return $_response->error_400();
        }else{
            $this->title=$data['title'];
            $this->shortDescription=$data['shortDescription'];
            $this->date=$data['date'];
            $this->category=$data['category'];

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
        if (!isset($data['idPost'])){
            return $_response->error_400();
        }else{
            $this->idPost=$data['idPost'];
            if (isset($data['title']))$this->title=$data['title'];
            if (isset($data['shortDescription']))$this->shortDescription=$data['shortDescription'];
            if (isset($data['date']))$this->date=$data['date'];
            if (isset($data['category']))$this->category=$data['category'];
            $update=$this->updateData();
            if ($update){
                $response=$_response->response;
                $response['result']=array(
                    "idPost"=>$this->idPost
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
        if (!isset($data['idPost'])){
            return $_response->error_400();
        }else{
            $this->idPost=$data['idPost'];
            $destroy=$this->deleteData();
            if ($destroy){
                $response=$_response->response;
                $response['result']=array(
                    "idPost"=>$this->idPost
                );
                return $response;
            }else{
                return $_response->error_500();
            }
        }
    }

    private function saveData(){
        $query ="INSERT INTO ".$this->table." (title,shortDescription,date,category)values('".$this->title."','".$this->shortDescription."','".$this->date."','".$this->category."')";
        $save = parent::nonQueryidPost($query);
        if ($save)return $save;
        else return 0;

    }
    private function updateData(){
        $query="UPDATE ".$this->table." SET title='".$this->title."', shortDescription='".$this->shortDescription."', date='".$this->date."', category='".$this->category."' WHERE idPost='".$this->idPost."'";
        $update=parent::nonQuery($query);
        if ($update>=1)return $update;
        else return 0;
    }
    private function deleteData(){
        $query="DELETE FROM ".$this->table." WHERE idPost='".$this->idPost."'";
        $destroy=parent::nonQuery($query);
        if ($destroy >=1)return $destroy;
        else return 0;
    }
}

?>