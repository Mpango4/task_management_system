<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
/*if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
*/
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'update_user'){
	$save = $crud->update_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'save_project'){
	$save = $crud->save_project();
	if($save)
		echo $save;
}
if($action == 'delete_project'){
	$save = $crud->delete_project();
	if($save)
		echo $save;
}
if($action == 'save_task'){
	$save = $crud->save_task();
	if($save)
		echo $save;
}
if($action == 'save_tasks'){
	$save = $crud->save_tasks();
	if($save)
		echo $save;
}
if($action == 'delete_task'){
	$save = $crud->delete_task();
	if($save)
		echo $save;
}
if($action == 'save_progress'){
	$save = $crud->save_progress();
	if($save)
		echo $save;
}
if($action == 'delete_progress'){
	$save = $crud->delete_progress();
	if($save)
		echo $save;
}
if($action == 'get_report'){
	$get = $crud->get_report();
	if($get)
		echo $get;
}

if($action == 'save_department'){
    $save = $crud->save_department(); // Method to handle saving department data
    if($save)
        echo $save;
}

if($action == 'update_status'){
    $save = $crud->update_status(); // Method to handle updating status data
    if($save)
        echo $save;
}

if($action == 'delete_department'){
    $save = $crud->delete_department();
    if($save)
        echo $save;
}


if($action == 'send_department_message'){
    // Assuming you have a function to handle saving messages to the database
    $save = $crud->save_department_message();
    if($save)
        echo $save; // Return 1 if the message is successfully saved
    // Return 0 if there's an error saving the message
}

ob_end_flush();

