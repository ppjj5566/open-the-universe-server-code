<?php

/**
 * author Ravi Tamada
 * link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

class DB_Functions {

    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    public function check_id($requested_email){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $requested_email);
        if($stmt->execute()){
            $user = $stmt->get_result()->fetch_assoc();
            $id = $user["user_provider_id"];
            $stmt->close();
            if($id == NULL || $id == "")
            {
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
        else
        {
            return FALSE;
        }
    }

    public function upload_provider_location_info($locx,$locy,$provider_id)
    {
      $stmt = $this->conn->prepare("UPDATE users SET user_provider_id = ? WHERE email = ?");
      $stmt->bind_param("ss", $provider_id, $provider_id);
      $result = $stmt->execute();
      $stmt->close();
        if($result){
          $stmt2 = $this->conn->prepare("INSERT INTO users_location_and_sign(id,location_x,location_y) VALUES (?,?,?)");
          $stmt2->bind_param("sss", $provider_id, $locx, $locy);
          $sec_result = $stmt2->execute();
          $stmt2->close();
          if($sec_result){
              $stmt3 = $this->conn->prepare( "INSERT INTO provider_story(id) VALUE (?)");
              $stmt3->bind_param("s", $provider_id);
              $result3 = $stmt3->execute();
              $stmt3->close();
            if($result3){
                return TRUE;
            }else{
                return FALSE;
            }
          }else{
            return FALSE;
           }
        }else{
            return FALSE;
        }
    }

    /**
     * Storing new user
     * returns user details
     */

    public function storeUser($name, $email, $password) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt

        $stmt = $this->conn->prepare("INSERT INTO users(unique_id, name, email, encrypted_password, salt, created_at) VALUES(?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $uuid, $name, $email, $encrypted_password, $salt);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
        } else {
            return false;
        }
    }



    /**
     * Get user by email and password
     */

    public function getUserByEmailAndPassword($email, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");

        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // verifying user password
            $salt = $user['salt'];
            $encrypted_password = $user['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }



    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }

    /**
     * Encrypting password
     * param password
     * returns salt and encrypted password
     */

    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */

    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }

}

?>
