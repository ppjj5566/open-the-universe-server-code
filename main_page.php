<?php

/**
 * Created by PhpStorm.
 * User: John
 * Date: 2017-09-02
 * Time: 오전 1:42
 */

require_once 'include/DB_Textures.php';
$db = new DB_Textures();

    $response = array("error" => False);

    if(isset($_POST['id'])){
        $id = $_POST['id'];

        $title_image = $db->send_image("title_image", $id);
        $title = $db->send_story("title", $id);
        $image = $db->send_image("image", $id);
        $story = $db->send_story("story", $id);

        $response["user"]["title"] = $title;
        $response["user"]["title_image"] = $title_image;
        $response["user"]["story"] = $story;
        $response["user"]["image"] = $image;

        echo json_encode($response);
    }else{
        $response["error_msg"] = "SQLite is problem";
        echo json_encode($response);
    }