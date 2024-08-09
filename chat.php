<?php 
//session_start();
if (isset($_SESSION['login_id']) && isset($_SESSION['department_id'])) {
    include 'db_connect.php';
    include 'app/helpers/department.php';
    include 'app/helpers/timeAgo.php';

    $department_id = $_SESSION['department_id'];
    $department_name = $_SESSION['login_department'];
    $chats = getDepartmentChats($department_id, $conn);
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$department_name?> Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styley.css">
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    .chat-message {
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 10px;
        max-width: 70%;
        word-wrap: break-word;
    }

    .chat-message.align-self-end {
        background-color: #d1e7dd; /* Sent message background */
    }

    .chat-message.align-self-start {
        background-color: #f8d7da; /* Received message background */
    }

    .chat-box {
        height: 400px;
        overflow-y: scroll;
    }
</style>


</head>
<body class="d-flex justify-content-center align-items-center vh-100">
<div class="col-md-12">	
			<img src="assets/img/kasulu.png" alt="kasulu home" width="100%">
		    </div>
    <div class="p-2 w-400 rounded shadow">
        <div>
        <div class="d-flex mb-3 p-3 bg-light justify-content-between align-items-center">
                <h3 class="fs-xs m-2"><?=$department_name; ?> Department</h3>
                <a href="index.php" class="btn btn-primary text text-white">Home</a>
                
            </div>

            <div class="shadow p-4 rounded d-flex flex-column mt-2 chat-box" id="chatBox">
                <?php if (!empty($chats)) { ?>
                    <?php foreach($chats as $chat) { ?>
                        <div class="chat-message <?php echo ($chat['user_id'] == $_SESSION['login_id']) ? 'align-self-end' : 'align-self-start'; ?> border rounded p-2 mb-1">
                            <small class="d-block"><strong><?= htmlspecialchars($chat['firstname']) ?></strong>: <?= htmlspecialchars($chat['message']) ?></small>
                            <small class="d-block"><?= htmlspecialchars($chat['created_at']) ?></small>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="alert alert-info text-center">
                        <i class="fa fa-comments d-block fs-big"></i>
                        No messages yet, start the conversation.
                    </div>
                <?php } ?>
            </div>

            <div class="input-group mb-3">
                <textarea cols="3" id="message" class="form-control"></textarea>
                <button class="btn btn-primary" id="sendBtn">
                    <i class="fa fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    var scrollDown = function() {
        let chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    scrollDown();

    $(document).ready(function() {
        $("#sendBtn").on('click', function() {
            let message = $("#message").val();
            if (message === "") return;

            $.post("app/ajax/insert_department_chat.php", {
                message: message,
                department_id: <?= $department_id ?>
            }, function(data, status) {
                $("#message").val("");
                $("#chatBox").append(data);
                scrollDown();
            });
        });

        let fetchData = function() {
            $.post("app/ajax/get_department_chats.php", {
                department_id: <?= $department_id ?>
            }, function(data, status) {
                $("#chatBox").html(data);
                scrollDown();
            });
        }

        fetchData();
        setInterval(fetchData, 500000);
    });
</script>

</body>
</html>
