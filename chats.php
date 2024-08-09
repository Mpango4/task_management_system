<?php
if (isset($_SESSION['login_firstname'])) {
    // Database connection file
    include 'app/db.conn.php';

    include 'app/helpers/user.php';
    include 'app/helpers/chat.php';
    include 'app/helpers/opened.php';
    include 'app/helpers/timeAgo.php';

    if (!isset($_GET['user'])) {
        header("Location: home.php");
        exit;
    }

    // Getting User data
    $chatWith = getUser($_GET['user'], $conn);

    if (empty($chatWith)) {
        header("Location: homes.php");
        exit;
    }

    $chats = getChats($_SESSION['login_id'], $chatWith['id'], $conn);
    opened($chatWith['id'], $conn, $chats);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System - Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="w-400 shadow p-4 rounded">
        <a href="index.php?page=homes" class="fs-4 link-dark">&#8592;</a>

        <div class="d-flex align-items-center">
            <h3 class="display-4 fs-sm m-2">
                <?= htmlspecialchars($chatWith['firstname']) ?> <br>
                <div class="d-flex align-items-center" title="online">
                    <?php if (isset($chatWith['last_seen']) && last_seen($chatWith['last_seen']) == "Active"): ?>
                        <div class="online"></div>
                        <small class="d-block p-1">Online</small>
                    <?php elseif (isset($chatWith['last_seen'])): ?>
                        <small class="d-block p-1">
                            Last seen: <?= last_seen($chatWith['last_seen']) ?>
                        </small>
                    <?php endif; ?>
                </div>
            </h3>
        </div>

        <div class="shadow p-4 rounded d-flex flex-column mt-2 chat-box" id="chatBox">
            <?php 
                if (!empty($chats)) {
                    foreach ($chats as $chat) {
                        if ($chat['from_id'] == $_SESSION['login_id']) { ?>
                            <p class="rtext align-self-end border rounded p-2 mb-1">
                                <?= htmlspecialchars($chat['message']) ?> 
                                <small class="d-block"><?= $chat['created_at'] ?></small>       
                            </p>
                        <?php } else { ?>
                            <p class="ltext border rounded p-2 mb-1">
                                <?= htmlspecialchars($chat['message']) ?> 
                                <small class="d-block"><?= $chat['created_at'] ?></small>       
                            </p>
                        <?php } 
                    }   
                } else { ?>
                    <div class="alert alert-info text-center">
                        <i class="fa fa-comments d-block fs-big"></i>
                        No messages yet, Start the conversation
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
                if (message == "") return;

                $.post("app/ajax/insert.php", {
                    message: message,
                    to_id: <?=$chatWith['id']?>
                }, function(data, status) {
                    $("#message").val("");
                    $("#chatBox").append(data);
                    scrollDown();
                });
            });

            // Auto update last seen for logged in user
            let lastSeenUpdate = function() {
                $.get("app/ajax/update_last_seen.php");
            }
            lastSeenUpdate();
            // Auto update last seen every 10 sec
            setInterval(lastSeenUpdate, 10000);

            // Auto refresh / reload
            let fetchData = function() {
                $.post("app/ajax/getMessage.php", {
                    id_2: <?=$chatWith['id']?>
                }, function(data, status) {
                    $("#chatBox").append(data);
                    if (data != "") scrollDown();
                });
            }

            fetchData();
            // Auto update last seen every 0.5 sec
            setInterval(fetchData, 500);
        });
    </script>
</body>
</html>
<?php
}
?>
