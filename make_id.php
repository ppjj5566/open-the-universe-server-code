<?php
  require_once 'include/DB_Functions.php';
  $db = new DB_Functions;

  $response = array("error" => FALSE);

  if(isset($_POST['provider_id']) && isset($_POST['locx']) && isset($_POST['locy'])){
      $provider_id = $_POST['provider_id'];
      $locx = $_POST['locx'];
      $locy = $_POST['locy'];

      $provider_loc = $db->upload_provider_location_info($locx,$locy,$provider_id);

      if($provider_loc){
        $response["upload_state"] = $provider_loc;
        echo json_encode($response);
      }else{
        $response["upload_state"] = $provider_loc;
        echo json_encode($response);
      }
    }else{
      $response["error_msg"] = "Some information is missing!!";
      echo json_encode($response);
  }
 ?>
