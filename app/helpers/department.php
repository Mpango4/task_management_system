<?php


function getDepartmentChats($department_id, $conn) {
    $sql = "SELECT department_chats.*, users.firstname FROM department_chats 
            JOIN users ON department_chats.user_id = users.id
            WHERE department_chats.department_id = ?
            ORDER BY department_chats.created_at ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $department_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function addDepartmentChat($department_id, $user_id, $message, $conn) {
    $sql = "INSERT INTO department_chats (department_id, user_id, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $department_id, $user_id, $message);
    return $stmt->execute();
}
?>
