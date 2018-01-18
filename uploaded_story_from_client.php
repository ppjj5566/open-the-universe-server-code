<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2017-09-01
 * Time: 오후 7:10
 */

require_once 'include/DB_Textures.php';
$db = new DB_Textures();

$response = array('error' => false);

    if(isset($_POST['story']) && isset($_POST['id']) && isset($_POST['number'])){
        $story = $_POST['story'];
        $id = $_POST['id'];
        $number = $_POST['number'];

        switch ($number){

            case 1:
                $user = $db->get_title($story,$id);
                $response["user"]["state"] = $user;
                echo json_encode($response);
                break;

            case 2:
                $user = $db->get_Story($story,$id);
                $response["user"]["state"] = $user;
                echo json_encode($response);
                break;

            default:
                $response["error_msg"] = "Image is didn't uploaded!";
                echo json_encode($response);
                break;

        }
    }
?>
