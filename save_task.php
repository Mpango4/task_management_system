<?php
// In ajax.php

if(isset($_POST['action']) && $_POST['action'] == 'save_task'){
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$project_id = isset($_POST['project_id']) ? $_POST['project_id'] : '';
	$task = isset($_POST['task']) ? $_POST['task'] : '';
	$description = isset($_POST['description']) ? $_POST['description'] : '';
	$status = isset($_POST['status']) ? $_POST['status'] : '';
	$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

	$attachment = '';
	if(isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0){
		$attachment = 'uploads/'.basename($_FILES['attachment']['name']);
		move_uploaded_file($_FILES['attachment']['tmp_name'], $attachment);
	}

	if(empty($id)){
		// Insert new task
		$stmt = $conn->prepare("INSERT INTO task_list (project_id, task, description, status, user_id, attachment) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("isssis", $project_id, $task, $description, $status, $user_id, $attachment);
		$stmt->execute();
		$stmt->close();
	} else {
		// Update existing task
		$stmt = $conn->prepare("UPDATE task_list SET task=?, description=?, status=?, user_id=?, attachment=? WHERE id=?");
		$stmt->bind_param("ssisi", $task, $description, $status, $user_id, $attachment, $id);
		$stmt->execute();
		$stmt->close();
	}

	echo 1;
	exit;
}
?>
