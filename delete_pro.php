<?php
include 'db_connect.php';

if(isset($_POST['action'])){
    if($_POST['action'] == 'delete_project'){
        $id = $_POST['id'];
        if($_SESSION['login_type'] == 1){ // Admin
            $delete_query = "DELETE FROM project_list WHERE id = $id";
        } else { // HoD
            $delete_query = "UPDATE project_list SET is_deleted = 'yes' WHERE id = $id";
        }
        if($conn->query($delete_query)){
            echo 1;
        } else {
            echo 0;
        }
    }
}
?>
