<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2017-11-07
 * Time: 오후 9:28
 */

    require_once 'include/DB_Textures.php';
    $db = new DB_Textures();

    $response = array("error" => False);

    if(isset($_POST['id'])){
        $id = $_POST['id'];

        $image = $db->send_image("head_image",$id);
        $title = $db->send_story("heed_title",$id);

        $response["user"]["image"] = $image;
        $response["user"]["title"] = $title;

        echo json_encode($response);
    }else{
        $response["id"] = "Send me the id";
        echo json_encode($response);
    }
