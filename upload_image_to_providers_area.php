  <?php

    require_once 'include/DB_Textures.php';
    $db = new DB_Textures();

  $response = array('error' => False);

    if(isset($_POST['id']) && isset($_POST['title_image']) && isset($_POST['number'])){
        $title_image_address = "title_image/";
        $image_address = "image/";
        $png = ".png";
      $image = $_POST['title_image'];
      $id = $_POST['id'];
      $number = $_POST['number'];

      switch ($number){

          case 1:
            $path = $title_image_address.substr($id,0,-4).$png;
            unlink($path);
            file_put_contents($path, base64_decode($image));
            $user = $db->get_title_Image($path,$id);
            $response["user"]["state"] = $user;
            echo json_encode($response);
            break;

          case 2:
            $path = $image_address.substr($id,0,-4).$png;
            unlink($path);
            file_put_contents($path, base64_decode($image));
            $user = $db->get_image($path,$id);
            $response["user"]["state"] = $user;
            echo json_encode($response);
            break;
      }
    }else{
        $response["error_msg"] = "need more information!!!";
        echo json_encode($response);
    }
  ?>
