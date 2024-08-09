<?php 
include('auth_session.php');

# Check if the user is logged in
if (isset($_SESSION['login_id'])) {
    if (isset($_POST['message']) && isset($_POST['to_id'])) {
        # Database connection file
        include '../db.conn.php';

        # Get data from XHR request and store them in variables
        $message = $_POST['message'];
        $to_id = $_POST['to_id'];

        # Get the logged in user's ID from the SESSION
        $from_id = $_SESSION['login_id'];

        # Prepare and execute the SQL statement to insert the message into the chats table
        $sql = "INSERT INTO chats (from_id, to_id, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$from_id, $to_id, $message]);
        
        # Check if the message was inserted successfully
        if ($stmt->affected_rows > 0) {
            /**
             * Check if this is the first
             * conversation between them
             **/
            $sql2 = "SELECT * FROM conversations
                     WHERE (user_1=? AND user_2=?)
                     OR    (user_2=? AND user_1=?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute([$from_id, $to_id, $from_id, $to_id]);

            // Setting up the time zone
            define('TIMEZONE', 'Africa/Addis_Ababa');
            date_default_timezone_set(TIMEZONE);
            $time = date("h:i:s a");

            // Fetch the results and count the rows
            $result = $stmt2->get_result();
            if ($result->num_rows == 0) {
                # Insert them into conversations table 
                $sql3 = "INSERT INTO conversations(user_1, user_2) VALUES (?,?)";
                $stmt3 = $conn->prepare($sql3); 
                $stmt3->execute([$from_id, $to_id]);
            }
            ?>
            <!-- Output the message with proper HTML formatting -->
            <p class="rtext align-self-end border rounded p-2 mb-1">
                <?= $message ?>  
                <small class="d-block"><?= $time ?></small>      	
            </p>
            <?php
        }
    }
}
?>
