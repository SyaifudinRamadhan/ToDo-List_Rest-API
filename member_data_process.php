<?php 

session_start();

require 'conn.php';
require 'get_data_function.php';
// $_SESSION['id_user_login'] = 3;


// if (isset($_SERVER['HTTP_ORIGIN'])) {
//     // should do a check here to match $_SERVER['HTTP_ORIGIN'] to a
//     // whitelist of safe domains
//     header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
//     header('Access-Control-Allow-Credentials: true');
//     header('Access-Control-Max-Age: 86400');    // cache for 1 day
// }
if(isset($_GET['id_login'])){
	$_SESSION['id_user_login'] = $_GET['id_login'];

$message = array();
$login = $_SESSION['id_user_login'];

if (isset($_POST['user_id']) and isset($_POST['project_id']) and isset($_POST['task_id'])){

	$user_id = $_POST['user_id'];
	$project_id = $_POST['project_id'];
	$task_id = $_POST['task_id'];

	//task user check
	$query_check = "SELECT * FROM members WHERE FK_Users = '$user_id' and FK_Projects = '$project_id' and FK_Tasks = '$task_id' ";

	$check = mysqli_query($conn, $query_check);
	$arr_check = array();
	while ($fetch = mysqli_fetch_assoc($check)){
		$arr_check[] = $fetch;
	}
	// echo count($arr_check);
	if (count($arr_check) == 0){
		//kirimkan
		// echo ("Masuk arr check ksong");
		$query = "INSERT INTO members(ID, group_name, FK_Users, FK_Projects, FK_Tasks) VALUES (0, '-', '$user_id', '$project_id', '$task_id')";

		$Q = mysqli_query($conn, $query);
		if ($Q){
			$message["valid"] = "true";
			$message["sending"] = "true";
		}else{
			$message["valid"] = "true";
			$message["sending"] = "false";
		}
	}else{
		$message["valid"] = "false";
		$message["sending"] = "false";
	}
	echo json_encode($message);

}else if(isset($_GET['delete'])){

	$ID = $_GET['delete'];

	$query = "DELETE FROM members WHERE ID = '$ID'";
	
	$Q = mysqli_query($conn, $query);
	if ($Q){
		$message["sending"] = "true";
		$check = mysqli_affected_rows($conn);
		if ($check > 0){
			$message["valid"] = "true";
		}else{
			$message["valid"] = "false";
		}
	}else{
		$message["valid"] = "false";
		$message["sending"] = "false";
	}
	echo json_encode($message);
	
}else{
	$message["valid"] = "false";
	$message["sending"] = "false";
	echo json_encode($message);
}

}

 ?>