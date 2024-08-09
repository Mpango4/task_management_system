<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'save_stakeholder':
            // Your save stakeholder code here...
            break;
        case 'delete_stakeholder':
            $id = $_POST['id'];
            $stmt = $conn->prepare("DELETE FROM stakeholders WHERE id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                echo 1;
            } else {
                echo $stmt->error;
            }
            $stmt->close();
            break;
        // Other actions...
    }
    $conn->close();
}
?>
