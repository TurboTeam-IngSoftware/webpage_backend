<?php

require_once "connection/connection.php";
require_once "response.php";

class Posts extends connection {

    private $table = "posts";
    private $idPost="";
    private $title="";
    private $shortDescription="";
    private $description="";
    private $author="";
    private $date="";
    private $photo="";
    private $category="";
    private $revised="";
    private $video="";

    public function listPosts() {
        $query = "SELECT * FROM " . $this->table;
        return parent::getData($query);
    }

    public function getPost($idPost) {
        $query = "SELECT * FROM " . $this->table . " WHERE idPost = '$idPost'";
        return parent:: getData($query);
    }

    public function store($json){
        $_response= new response();
        $data = json_decode($json,true);
        if (!isset($data['title'])||!isset($data['shortDescription'])||!isset($data['description'])||!isset($data['author'])||!isset($data['date'])||!isset($data['photo'])||!isset($data['category'])||!isset($data['revised'])||!isset($data['video'])){
            return $_response->error_400();
        }else{
            $this->title=$data['title'];
            $this->shortDescription=$data['shortDescription'];
            $this->description=$data['description'];
            $this->author=$data['author'];
            $this->date=$data['date'];
            $this->photo=$data['photo'];
            $this->category=$data['category'];
            $this->revised=$data['revised'];
            $this->video=$data['video'];

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
            if (isset($data['description']))$this->description=$data['description'];
            if (isset($data['author']))$this->author=$data['author'];
            if (isset($data['date']))$this->date=$data['date'];
            if (isset($data['photo']))$this->photo=$data['photo'];
            if (isset($data['category']))$this->category=$data['category'];
            if (isset($data['revised']))$this->revised=$data['revised'];
            if (isset($data['video']))$this->video=$data['video'];
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
        $query ="INSERT INTO ".$this->table." (title,shortDescription,description,author,date,photo,category,revised,video) values('".$this->title."','".$this->shortDescription."','".$this->description."','".$this->author."','".$this->date."','".$this->photo."','".$this->category."','".$this->revised."','".$this->video."')";
        $save = parent::nonQueryId($query);
        if ($save)return $save;
        else return 0;

    }
    private function updateData(){
        $query="UPDATE ".$this->table." SET title='".$this->title."', shortDescription='".$this->shortDescription."', description='".$this->description."', author='".$this->author."', date='".$this->date."', photo='".$this->photo."', category='".$this->category."', revised='".$this->revised."', video='".$this->video."' WHERE idPost='".$this->idPost."'";
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