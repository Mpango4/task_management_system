<?php
session_start();
include 'db_connect.php';

class AjaxHandler {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function delete_user(){
        extract($_POST);
        $delete = $this->db->query("DELETE FROM users WHERE id = ".$id);
        if($delete)
            return 1;
    }

    public function update_status(){
        extract($_POST);
        $update = $this->db->query("UPDATE users SET status = '$status' WHERE id = ".$id);
        if($update)
            return 1;
    }
}


?>
