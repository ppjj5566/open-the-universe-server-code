<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2017-09-12
 * Time: 오후 8:02
 */

    require_once 'include/DB_Connect.php';
    require_once 'include/DB_Textures.php';
    $db2 = new DB_Textures();
    $db = new DB_Connect();
    $conn = $db->connect();

    $stmt = $conn->query("SELECT * FROM users_location_and_sign");
    $users_array = array();
        foreach ($stmt as $row) {
            $json_array["location_x"] = doubleval(substr($row["location_x"], 0, -9));
            $json_array["location_y"] = doubleval(substr($row["location_y"], 0, -9));
            $json_array["id"] = $row["id"];
            $json_array["head_image"] = $db2->send_image("head_image", $row["id"]);
            $json_array["heed_title"] = $db2->send_story("heed_title", $row["id"]);
            array_push($users_array, $json_array);
        }
echo json_encode($users_array);