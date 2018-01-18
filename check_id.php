<?php
    require_once 'include/DB_Functions.php';
    $db = new DB_Functions();

    $response = array("error" => FALSE);

    if(isset($_POST['email'])){
        $email = $_POST['email'];
        $user = $db->check_id($email);

        if($user == true){
            $response["error"] = FALSE;
            $response["user"]["provider_user_id"] = TRUE;
            echo json_encode($response);
        }else{
            $response["error"] = FALSE;
            $response["user"]["provider_user_id"] = FALSE;
            echo json_encode($response);
        }
    }else {
        // required post params is missing
        $response["error"] = TRUE;
        $response["error_msg"] = "Can't find a id";
        echo json_encode($response);
    }
?>
