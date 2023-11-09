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
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}

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
if($action == 'update_donation_status'){
	$save = $crud->update_donation_status();
	if($save)
		echo $save;
}
if($action == 'update_project_status'){
	$save = $crud->update_project_status();
	if($save)
		echo $save;
}
if($action == 'resetPassword'){
	$resetPassword = $crud->resetPassword();
	if($resetPassword)
		echo $resetPassword;
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
if($action == 'save_investment'){
	$save = $crud->save_investment();
	if($save)
		echo $save;
}
if($action == 'save_donation'){
	$save = $crud->save_donation();
	if($save)
		echo $save;
}
if($action == 'delete_project'){
	$save = $crud->delete_project();
	if($save)
		echo $save;
}
if($action == 'delete_investment'){
	$save = $crud->delete_investment();
	if($save)
		echo $save;
}
if($action == 'delete_donation'){
	$save = $crud->delete_donation();
	if($save)
		echo $save;
}
if($action == 'delete_request'){
	$save = $crud->delete_request();
	if($save)
		echo $save;
}
if($action == 'get_report'){
	$get = $crud->get_report();
	if($get)
		echo $get;
}
ob_end_flush();
?>
