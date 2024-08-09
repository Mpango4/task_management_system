<?php
session_start();
ini_set('display_errors', 1);

class Action {
    private $db;

    public function __construct() {
        include 'db_connect.php';
        $this->db = $conn;
    }
	
    function __destruct() {
        $this->db->close();
    }

	// function login() {
	// 	extract($_POST);
	// 	$qry = $this->db->query("SELECT *, CONCAT(firstname, ' ', lastname) AS name, department_id FROM users WHERE email = '$email' AND password = '" . md5($password) . "'");
	// 	if ($qry->num_rows > 0) {
	// 		$row = $qry->fetch_assoc();
	// 		foreach ($row as $key => $value) {
	// 			if ($key != 'password' && !is_numeric($key)) {
	// 				$_SESSION['login_' . $key] = $value;
	// 			}
	// 		}
	// 		// Fetch and store the department name in session
	// 		$department_id = $row['department_id'];
	// 		$department_query = $this->db->query("SELECT department_name FROM departments WHERE id = '$department_id'");
	// 		if ($department_query->num_rows > 0) {
	// 			$department_row = $department_query->fetch_assoc();
	// 			$_SESSION['login_department'] = $department_row['department_name'];
	// 		}
	// 		return 1;
	// 	} else {
	// 		return 2;
	// 	}
	// }

	function login() {
		extract($_POST);
		$qry = $this->db->query("SELECT *, CONCAT(firstname, ' ', lastname) AS name, department_id FROM users WHERE email = '$email' AND password = '" . md5($password) . "'");
		if ($qry->num_rows > 0) {
			$row = $qry->fetch_assoc();
			
			// Check if the user's status is active
			if ($row['status'] == 'active') {
				foreach ($row as $key => $value) {
					if ($key != 'password' && !is_numeric($key)) {
						$_SESSION['login_' . $key] = $value;
					}
				}
				// Fetch and store the department name in session
				$department_id = $row['department_id'];
				$department_query = $this->db->query("SELECT department_name FROM departments WHERE id = '$department_id'");
				if ($department_query->num_rows > 0) {
					$department_row = $department_query->fetch_assoc();
					$_SESSION['login_department'] = $department_row['department_name'];
				}
				return 1; // Login successful
			} else {
				return 3; // User is inactive
			}
		} else {
			return 2; // Invalid login credentials
		}
	}
	
	
	

    function logout() {
        session_destroy();
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        header("location: login.php");
    }
	function login2(){
		extract($_POST);
			$qry = $this->db->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM students where student_code = '".$student_code."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['rs_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function save_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','password')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(!empty($password)){
					$data .= ", password=md5('$password') ";

		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}
		else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}
	function signup(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass')) && !is_numeric($k)){
				if($k =='password'){
					if(empty($v))
						continue;
					$v = md5($v);

				}
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}

		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");

		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			if(empty($id))
				$id = $this->db->insert_id;
			foreach ($_POST as $key => $value) {
				if(!in_array($key, array('id','cpass','password')) && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
					$_SESSION['login_id'] = $id;
				if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
					$_SESSION['login_avatar'] = $fname;
			return 1;
		}
	}

	function update_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','table','password')) && !is_numeric($k)){
				
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";

		}
		if(!empty($password))
			$data .= " ,password=md5('$password') ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			foreach ($_POST as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
					$_SESSION['login_avatar'] = $fname;
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}

	//################## status update functions ##########

	public function update_status(){
        extract($_POST);
        $update = $this->db->query("UPDATE users SET status = '$status' WHERE id = ".$id);
        if($update)
            return 1;
	}
// Inside admin_class.php

function delete_department(){
    extract($_POST);
    $delete = $this->db->query("DELETE FROM departments WHERE id = ".$id);
    if($delete)
        return 1;
}


	function save_system_settings(){
		extract($_POST);
		$data = '';
		foreach($_POST as $k => $v){
			if(!is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if($_FILES['cover']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['cover']['name'];
			$move = move_uploaded_file($_FILES['cover']['tmp_name'],'../assets/uploads/'. $fname);
			$data .= ", cover_img = '$fname' ";

		}
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set $data where id =".$chk->fetch_array()['id']);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set $data");
		}
		if($save){
			foreach($_POST as $k => $v){
				if(!is_numeric($k)){
					$_SESSION['system'][$k] = $v;
				}
			}
			if($_FILES['cover']['tmp_name'] != ''){
				$_SESSION['system']['cover_img'] = $fname;
			}
			return 1;
		}
	}
	function save_image(){
		extract($_FILES['file']);
		if(!empty($tmp_name)){
			$fname = strtotime(date("Y-m-d H:i"))."_".(str_replace(" ","-",$name));
			$move = move_uploaded_file($tmp_name,'assets/uploads/'. $fname);
			$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
			$hostName = $_SERVER['HTTP_HOST'];
			$path =explode('/',$_SERVER['PHP_SELF']);
			$currentPath = '/'.$path[1]; 
			if($move){
				return $protocol.'://'.$hostName.$currentPath.'/assets/uploads/'.$fname;
			}
		}
	}
	function save_project(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','user_ids')) && !is_numeric($k)){
				if($k == 'description')
					$v = htmlentities(str_replace("'","&#x2019;",$v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(isset($user_ids)){
			$data .= ", user_ids='".implode(',',$user_ids)."' ";
		}
		// echo $data;exit;
		if(empty($id)){
			$save = $this->db->query("INSERT INTO project_list set $data");
		}else{
			$save = $this->db->query("UPDATE project_list set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}
	// function delete_project(){
	// 	extract($_POST);
	// 	$delete = $this->db->query("DELETE FROM project_list where id = $id");
	// 	if($delete){
	// 		return 1;
	// 	}
	// }
	function delete_project(){
		extract($_POST);
		
		if ($_SESSION['login_type'] == 1) { // Admin
			$delete = $this->db->query("DELETE FROM project_list WHERE id = $id");
		} else { // HoD
			$delete = $this->db->query("UPDATE project_list SET is_deleted = 'yes' WHERE id = $id");
		}
		
		if($delete){
			return 1;
		}
	}
	
	function save_task(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'description')
					$v = htmlentities(str_replace("'","&#x2019;",$v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO task_list set $data");
		}else{
			$save = $this->db->query("UPDATE task_list set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}

	//################# deligations task ##########################
	function save_tasks(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'description')
					$v = htmlentities(str_replace("'","&#x2019;",$v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
	
		if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
			$filename = $_FILES['attachment']['name'];
			$filepath = 'uploads/' . $filename;
			if (move_uploaded_file($_FILES['attachment']['tmp_name'], $filepath)) {
				$data .= ", attachment='$filepath' ";
			} else {
				echo json_encode(['status' => 0, 'message' => 'File upload failed']);
				return;
			}
		} elseif (isset($_FILES['attachment']) && $_FILES['attachment']['error'] != 0) {
			echo json_encode(['status' => 0, 'message' => 'File upload error code: ' . $_FILES['attachment']['error']]);
			return;
		}
	
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO task_list set $data");
		} else {
			$save = $this->db->query("UPDATE task_list set $data where id = $id");
		}
	
		if ($save) {
			echo json_encode(['status' => 1]);
		} else {
			echo json_encode(['status' => 0, 'message' => 'Database operation failed: ' . $this->db->error]);
		}
	}
	
	//save_task();
	//####################### END #######################################
	
	function delete_task(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM task_list where id = $id");
		if($delete){
			return 1;
		}
	}
	function save_progress(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'comment')
					$v = htmlentities(str_replace("'","&#x2019;",$v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$dur = abs(strtotime("2020-01-01 ".$end_time)) - abs(strtotime("2020-01-01 ".$start_time));
		$dur = $dur / (60 * 60);
		$data .= ", time_rendered='$dur' ";
		// echo "INSERT INTO user_productivity set $data"; exit;
		if(empty($id)){
			$data .= ", user_id={$_SESSION['login_id']} ";
			
			$save = $this->db->query("INSERT INTO user_productivity set $data");
		}else{
			$save = $this->db->query("UPDATE user_productivity set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}
	function delete_progress(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM user_productivity where id = $id");
		if($delete){
			return 1;
		}
	}
	function get_report(){
		extract($_POST);
		$data = array();
		$get = $this->db->query("SELECT t.*,p.name as ticket_for FROM ticket_list t inner join pricing p on p.id = t.pricing_id where date(t.date_created) between '$date_from' and '$date_to' order by unix_timestamp(t.date_created) desc ");
		while($row= $get->fetch_assoc()){
			$row['date_created'] = date("M d, Y",strtotime($row['date_created']));
			$row['name'] = ucwords($row['name']);
			$row['adult_price'] = number_format($row['adult_price'],2);
			$row['child_price'] = number_format($row['child_price'],2);
			$row['amount'] = number_format($row['amount'],2);
			$data[]=$row;
		}
		return json_encode($data);

	}

	// function save_department(){
	// 	extract($_POST);
	
	// 	// Check if the department name is provided
	// 	if(empty($department)){
	// 		return 0; // Return 0 to indicate failure
	// 	}
	// 	if(empty($description)){
	// 		return -1; // Return -1 to indicate failure due to the missing description
	// 	}
	
	// 	// Prepare and bind parameters for safe insertion
	// 	$stmt = $this->db->prepare("INSERT INTO departments (department_name, description) VALUES (?, ?)");
	// 	$stmt->bind_param("ss", $department, $description);
	
	// 	// Execute the statement
	// 	$success = $stmt->execute();
	
	// 	// Check for errors
	// 	if(!$success){
	// 		// Log the SQL error
	// 		error_log('MySQL Error: ' . $stmt->error);
	// 		return -3; // Return -3 to indicate database error
	// 	}
	
	// 	return 1; // Return 1 to indicate success
	// }
	

	function save_department_message(){
		
			extract($_POST);
			
			// Check if the message is provided
			if(empty($message)){
				return 0; // Return 0 to indicate failure
			}
			
			// Check if the sender ID is provided
			if(empty($sender_id)){
				return -1; // Return -1 to indicate failure due to missing sender ID
			}
			
			// Fetch all department members' IDs based on the sender's department
			$department_id_query = $this->db->query("SELECT department_id FROM users WHERE id = '$sender_id'");
			$department_id_result = $department_id_query->fetch_assoc();
			$department_id = $department_id_result['department_id'];
			
			$receiver_ids_query = $this->db->query("SELECT id FROM users WHERE department_id = '$department_id'");
			$receiver_ids = [];
			while($row = $receiver_ids_query->fetch_assoc()) {
				$receiver_ids[] = $row['id'];
			}
			
			// Insert the new chat into the database for each department member
			foreach($receiver_ids as $receiver_id) {
				$save = $this->db->query("INSERT INTO chats (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$message')");
				if(!$save){
					return -3; // Return -3 to indicate database error
				}
			}
			
			return 1; // Return 1 to indicate success
		}
	}