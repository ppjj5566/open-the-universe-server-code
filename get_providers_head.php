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
$address = "head_image/";
$png = ".png";

if(isset($_POST['id']) && isset($_POST['image']) && isset($_POST['title'])){
    $id = $_POST['id'];
    $string_image = $_POST['image'];
    $title = $_POST['title'];

    $file_path = $address.substr($id,0,-4).$png;
    $image = base64_decode($string_image);

    unlink($file_path);
    file_put_contents($file_path,$image);

    $state1 = $db->get_Head_image($file_path, $id);
    $state2 = $db->get_Head_title($title,$id);

    if($state1){
        $response["user"]["state"] = True;
        echo json_encode($response);
    }
}else{
    $response["user"]["state"] = False;
    $response["error_msg"] = "Something is missing";
    echo json_encode($response);
}
