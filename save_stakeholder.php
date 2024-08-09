<?php
session_start();
include 'db_connect.php'; // Include database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'save_stakeholder') {
    $company_name = $_POST['company_name'];
    $address = $_POST['address'];
    $location = $_POST['location'];
    $department_id = $_POST['department_id'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    if (empty($id)) {
        // Insert new stakeholder
        $stmt = $conn->prepare("INSERT INTO stakeholders (company_name, address, location, department_id, email, phone) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $company_name, $address, $location, $department_id, $email, $phone);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Stakeholder successfully added."]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }
    } else {
        // Update existing stakeholder
        $stmt = $conn->prepare("UPDATE stakeholders SET company_name = ?, address = ?, location = ?, department_id = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("sssissi", $company_name, $address, $location, $department_id, $email, $phone, $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Stakeholder successfully updated."]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }
    }

    $stmt->close();
    $conn->close();
}
?>
