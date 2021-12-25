<?php 

session_start();

require 'conn.php';
require 'get_data_function.php';
// // $_SESSION['id_user_login'] = 3;

// if (isset($_SERVER['HTTP_ORIGIN'])) {
//     // should do a check here to match $_SERVER['HTTP_ORIGIN'] to a
//     // whitelist of safe domains
//     header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
//     header('Access-Control-Allow-Credentials: true');
//     header('Access-Control-Max-Age: 86400');    // cache for 1 day
// }
if(isset($_GET['id_login'])){
	$_SESSION['id_user_login'] = $_GET['id_login'];

if (isset($_SESSION['id_user_login'])){
	$query = "SELECT * FROM users";
	$data_q = mysqli_query($conn, $query);

	$arr = array();
	while($fetch = mysqli_fetch_assoc($data_q)){
		$arr[] = $fetch;
	}

	echo json_encode($arr);
}

}

?>