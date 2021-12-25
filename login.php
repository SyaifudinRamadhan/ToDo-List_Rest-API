<?php 
session_start();
require 'login_sys.php';

if (isset($_SERVER['HTTP_ORIGIN'])) {
    // should do a check here to match $_SERVER['HTTP_ORIGIN'] to a
    // whitelist of safe domains
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

$msg = NULL;


// $password = 'Misaka12';

// $val_$username = 'Misaka Mikoto';
// login = login($username, $password);

// if ($val_login == NULL){
// 	$msg = "username tidak tersedia";
// }else if ($val_login == -1){
// 	$msg = "password salah";
// }else{
// 	$_SESSION['id_user_login'] = $val_login;
// 	$msg = $val_login;
// }

if (isset($_POST['login'])){
	$message = array();
	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);

	$val_login = login($username, $password);
	// var_dump($val_login);

	if($val_login != NULL and $val_login != -1){
		$_SESSION['id_user_login'] = $val_login;
		$message['id_login'] = $val_login;
		$message['valid'] = "true";
		$message['sending'] = "true";
	}else{
		$message['id_user_login'] = "";
		$message['valid'] = "false";
		$message['sending'] = "true";
	}
	echo json_encode($message);
}else if(isset($_POST['sign_up'])){
	$message = array();
	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);
	$f_name = htmlspecialchars($_POST['f_name']);
	$l_name = htmlspecialchars($_POST['l_name']);
	$full_name = htmlspecialchars($_POST['full_name']);
	$phone = htmlspecialchars($_POST['phone_num']);

	$val_login = sign_up($username, $password, $f_name, $l_name, $full_name, $phone);

	if($val_login != NULL and $val_login != -1){
		$_SESSION['id_user_login'] = $val_login;
		$message['id_login'] = $val_login;
		$message['valid'] = "true";
		$message['sending'] = "true";
	}else{
		$message['id_user_login'] = "";
		$message['valid'] = "false";
		$message['sending'] = "true";
	}
	echo json_encode($message);
}

 ?>