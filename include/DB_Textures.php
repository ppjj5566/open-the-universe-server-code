<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2017-08-31
 * Time: 오후 9:19
 */


class DB_Textures{

    private $conn;

    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new DB_Connect();
        $this->conn = $db->connect();
    }

    public function get_title_Image($image, $id){
        $stmt = $this->conn->prepare("UPDATE provider_story SET title_image = ? WHERE id = ?");
        $stmt->bind_param("ss", $image, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function get_title($story, $id){
        $stmt = $this->conn->prepare("UPDATE provider_story SET title = ? WHERE id = ?");
        $stmt->bind_param("ss",$story,$id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function get_image($image, $id){
        $stmt = $this->conn->prepare("UPDATE provider_story SET image = ? WHERE id = ?");
        $stmt->bind_param("ss", $image, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function get_Story($story, $id){
        $stmt = $this->conn->prepare("UPDATE provider_story SET story = ? WHERE id = ?");
        $stmt->bind_param("ss", $story, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function get_Head_image($image, $id)
    {
        $stmt = $this->conn->prepare("UPDATE provider_story SET head_image = ? WHERE id = ?");
        $stmt->bind_param("ss", $image, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function get_Head_title($title, $id)
    {
        $stmt = $this->conn->prepare("UPDATE provider_story SET heed_title = ? WHERE id = ?");
        $stmt->bind_param("ss", $title, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }


    public function send_image($type_of_data, $id){
        $stmt = $this->conn->prepare("SELECT * FROM provider_story WHERE id = ? ");
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        if($result){
            $info = $stmt->get_result()->fetch_assoc();
            $story = $info[$type_of_data];
            if($story == null) {
                $image = "add_info_png/add_image.png";
                $stmt->close();
            }else{
                $image = $story;
                $stmt->close();
            }
            return $image;
        }else{
            return False;
        }
    }

    public function send_story($type_of_data, $id){
        $stmt = $this->conn->prepare("SELECT * FROM provider_story WHERE id = ? ");
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        if($result){
            $info = $stmt->get_result()->fetch_assoc();
            $story = $info[$type_of_data];
            $stmt->close();
            return $story;
        }else{
            return False;
        }
    }
}