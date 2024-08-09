<?php 
include 'db_connect.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['action']) && $_POST['action'] == 'save_project') {
    $data = [];
    $id = isset($_POST['id']) ? $conn->real_escape_string($_POST['id']) : '';
    $name = $conn->real_escape_string($_POST['name']);
    $status = $conn->real_escape_string($_POST['status']);
    $start_date = $conn->real_escape_string($_POST['start_date']);
    $end_date = $conn->real_escape_string($_POST['end_date']);
    $description = $conn->real_escape_string($_POST['description']);
    $manager_id = $conn->real_escape_string($_POST['manager_id']);
    $user_ids = isset($_POST['user_ids']) ? implode(',', array_map([$conn, 'real_escape_string'], $_POST['user_ids'])) : '';

    $data = [
        'name' => $name,
        'status' => $status,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'description' => $description,
        'manager_id' => $manager_id,
        'user_ids' => $user_ids
    ];

    if (empty($id)) {
        // Insert new project
        $sql = "INSERT INTO project_list (name, status, start_date, end_date, description, manager_id, user_ids) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sisssss', $name, $status, $start_date, $end_date, $description, $manager_id, $user_ids);
        $stmt->execute();
        $project_id = $stmt->insert_id;
        //$stmt->close();
        
        // Debugging
        error_log("Inserting new project, sending email");

        $result = $conn->query("SELECT email FROM users WHERE id = $manager_id");
        $manager_email = $result->fetch_assoc()['email'];

        // Send an email notification
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mpangosogo0102@gmail.com';
            $mail->Password = 'udzt ovxr vfuo qfgm';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('mpangosogo0102@gmail.com', 'TASK MANAGEMENT');
            $mail->addAddress($manager_email);
            $mail->isHTML(true);
            $mail->Subject = 'New Project Assigned';
            $mail->Body    = "Hello,<br><br>You have been assigned a new project:<br><strong>Project Name:</strong> $name<br><strong>Start Date:</strong> $start_date<br><strong>End Date:</strong> $end_date<br><strong>Description:</strong> $description<br><br>Regards,<br>Your Company";
            $mail->send();

            // Debugging
            error_log("Email sent successfully");
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

    } else {
        // Update existing project
        $sql = "UPDATE project_list SET name = ?, status = ?, start_date = ?, end_date = ?, description = ?, manager_id = ?, user_ids = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sisssssi', $name, $status, $start_date, $end_date, $description, $manager_id, $user_ids, $id);
        $stmt->execute();
        $stmt->close();
        
        // Debugging
        error_log("Updating project, sending email");

        $result = $conn->query("SELECT email FROM users WHERE id = $manager_id");
        $manager_email = $result->fetch_assoc()['email'];

        // Send an email notification
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mpangosogo0102@gmail.com';
            $mail->Password = 'udzt ovxr vfuo qfgm';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('mpangosogo0102@gmail.com', 'TASK MANAGEMENT');
            $mail->addAddress($manager_email);
            $mail->isHTML(true);
            $mail->Subject = 'Project Details Updated';
            $mail->Body    = "Hello,<br><br>The details of the project you are managing have been updated:<br><strong>Project Name:</strong> $name<br><strong>Start Date:</strong> $start_date<br><strong>End Date:</strong> $end_date<br><strong>Description:</strong> $description<br><br>Regards,<br>Your Company";
            $mail->send();

            // Debugging
            error_log("Email sent successfully");
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }

    echo 1;
}
