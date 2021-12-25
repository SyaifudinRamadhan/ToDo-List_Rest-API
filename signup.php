<?php 
session_start();
require 'login_sys.php';

$msg = NULL;

$username='Misaka Mikoto';
$password='Misaka12';
$f_name='Misaka';
$l_name='Mikoto';
$full_name='Misaka Mikoto';
$telp_number='081215848233';

$val_signup = sign_up($username, $password, $f_name, $l_name, $full_name, $telp_number);

if ($val_signup == -1){
	$msg = "Gagal singup";
	echo($msg);
}else{
	$val_login = login($username, $password);
	$_SESSION['id_user_login'] = $val_login;
	$msg = "signup sukses";
	echo($msg);
}

 ?>