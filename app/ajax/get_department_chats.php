
<?php
session_start();
if (isset($_SESSION['login_id']) && isset($_POST['department_id'])) {
    include '../db.conn.php';
    include '../helpers/department.php';
    include '../helpers/timeAgo.php';

    $department_id = $_POST['department_id'];
    $chats = getDepartmentChats($department_id, $conn);

    foreach ($chats as $chat) {
        echo '<div class="chat-message ' . ($chat['user_id'] == $_SESSION['login_id'] ? 'align-self-end' : 'align-self-start') . ' border rounded p-2 mb-1">
                <small class="d-block"><strong>' . htmlspecialchars($chat['firstname']) . '</strong>: ' . htmlspecialchars($chat['message']) . '</small>
                <small class="d-block">' . $chat['created_at'] . '</small>
              </div>';
    }
}
?>
