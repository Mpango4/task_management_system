<?php
include 'db_connect.php';

$update_status_query = "UPDATE project_list SET status = 4 WHERE status = 0 AND end_date < CURDATE()";
$conn->query($update_status_query);
?>
