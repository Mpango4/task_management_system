<?php

function lastChat($id_1, $id_2, $conn) {
    $sql = "SELECT * FROM chats
            WHERE (from_id=? AND to_id=?)
            OR    (to_id=? AND from_id=?)
            ORDER BY chat_id DESC LIMIT 1";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $id_1, $id_2, $id_1, $id_2); // Bind parameters as integers
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result set

    if ($result->num_rows > 0) { // Check if there are any rows
        $chat = $result->fetch_assoc(); // Fetch the result as an associative array
        return $chat['message']; // Return the message
    } else {
        return ''; // Return an empty string if no results
    }
}

?>
