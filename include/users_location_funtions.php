<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2017-09-12
 * Time: 오후 5:20
 */

class users_location_funtions
{
    private $conn;

    function __construct()
    {
        require_once 'DB_Connect.php';
        $db = new DB_Connect();
        $this->conn = $db->connect();
    }

    public function users_id()
    {
        $stmt = $this->conn->prepare("SELECT * FROM user_location_and_sign");
        return $stmt;
    }
}