<?php
session_start();
if (isset($_SESSION['login_id']) && isset($_POST['message']) && isset($_POST['department_id'])) {
    include '../db.conn.php';
    include '../helpers/department.php';

    $user_id = $_SESSION['login_id'];
    $message = $_POST['message'];
    $department_id = $_POST['department_id'];

    if (addDepartmentChat($department_id, $user_id, $message, $conn)) {
        // Fetch the new chat to display
        $chats = getDepartmentChats($department_id, $conn);
        $lastChat = end($chats); // Get the last chat

        if ($lastChat) {
            echo '<div class="chat-message ' . ($lastChat['user_id'] == $_SESSION['login_id'] ? 'align-self-end' : 'align-self-start') . ' border rounded p-2 mb-1">
                    <small class="d-block"><strong>' . htmlspecialchars($lastChat['firstname']) . '</strong>: ' . htmlspecialchars($lastChat['message']) . '</small>
                    <small class="d-block">' . htmlspecialchars($lastChat['created_at']) . '</small>
                  </div>';
        }
    }
}
?>
