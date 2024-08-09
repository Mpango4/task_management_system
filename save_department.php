<?php
// Include database connection
include 'db_connect.php';

// Include your database connection or initialization file here
// Example: require_once 'config.php';

// Check if the form data has been submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract the form data
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $department_name = $_POST['department_name'];
    $description = $_POST['description'];

    // Validate and sanitize input (not shown in detail here, but should be done)
    // For example, you can use mysqli_real_escape_string or prepared statements to prevent SQL injection

    // Include your database connection file or establish connection
    // Example assuming you have a connection to database already:
    // $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the department name already exists
    $check_query = "SELECT * FROM departments WHERE department_name = '$department_name'";
    $check_result = $conn->query($check_query);
    if ($check_result === false) {
        // Error handling for query failure
        $error_msg = "Error: " . $conn->error;
        echo -3; // Return -3 to indicate database error
        exit;
    }

    if ($check_result->num_rows > 0) {
        // Department name already exists
        echo -2; // Return -2 to indicate department name already exists
        exit;
    }

    // Insert or update the department information into the database
    if (!empty($id)) {
        // Update existing department
        $sql = "UPDATE departments SET department_name = '$department_name', description = '$description' WHERE id = $id";
    } else {
        // Insert new department
        $sql = "INSERT INTO departments (department_name, description) VALUES ('$department_name', '$description')";
    }

    if ($conn->query($sql) === true) {
        echo 1; // Return 1 to indicate success
    } else {
        // Error handling for query execution
        $error_msg = "Error: " . $conn->error;
        echo -3; // Return -3 to indicate database error
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request";
}
?>
