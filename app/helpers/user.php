<?php  

function getUser($login_firstname, $conn){
        $sql = "SELECT * FROM users 
                WHERE firstname=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $login_firstname); // Bind parameters
        $stmt->execute(); // Execute the statement
    
        // Get the result set
        $result = $stmt->get_result();
    
        // Check if any rows are returned
        if ($result->num_rows > 0) {
            // Fetch the user data as an associative array
            $user = $result->fetch_assoc();
            return $user;
        } else {
            // Return null if user not found
            return null;
        }
    }
    
