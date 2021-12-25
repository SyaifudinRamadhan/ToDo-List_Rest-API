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


$login = $_SESSION['id_user_login'];

$message = array();

if (isset($_POST['edit'])){

	if (isset($_POST['name_prj']) and isset($_POST['f_date']) and isset($_POST['end_date']) and isset($_POST['desc']) and isset($_POST['comp']) and isset($_POST['ID'])){

		$name_prj = htmlspecialchars($_POST['name_prj']);
		$f_date = htmlspecialchars($_POST['f_date']);
		$end_date = htmlspecialchars($_POST['end_date']);
		$desc = htmlspecialchars($_POST['desc']);
		$comp = htmlspecialchars($_POST['comp']);
		$ID = $_POST['ID'];
		
		$query = "UPDATE projects SET project_name='$name_prj',start_date='$f_date',end_date='$end_date',description='$desc',company='$comp' WHERE ID = '$ID'";

		$Q = mysqli_query($conn, $query);

		if ($Q){
			$message["valid"] = "true";
			$message["sending"] = "true";
			$message["query"] = $query;
		}else{
			$message["valid"] = "true";
			$message["sending"] = "false";
			$message["query"] = $query;
		}

		echo json_encode($message);

	}else{
		$message["valid"] = "false";
		$message["sending"] = "false";
		echo json_encode($message);
	}

}else if(isset($_GET['delete'])){

	$ID = $_GET['delete'];

	$query = "DELETE FROM projects WHERE ID = '$ID'";
	
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
	if (isset($_POST['name_prj']) and isset($_POST['f_date']) and isset($_POST['end_date']) and isset($_POST['desc']) and isset($_POST['comp'])){

		$name_prj = htmlspecialchars($_POST['name_prj']);
		$f_date = htmlspecialchars($_POST['f_date']);
		$end_date = htmlspecialchars($_POST['end_date']);
		$desc = htmlspecialchars($_POST['desc']);
		$comp = htmlspecialchars($_POST['comp']);
		
		$query = "INSERT INTO projects(ID, project_name, start_date, end_date, description, company) VALUES (0,'$name_prj','$f_date','$end_date','$desc','$comp')";

		$Q = mysqli_query($conn, $query);

		if ($Q){
			$inserted = mysqli_insert_id($conn);
			$query = "INSERT INTO members(ID, group_name, FK_Users, FK_Projects, FK_Tasks) VALUES (0,'$name_prj','$login','$inserted',null)";
			$F_Q = mysqli_query($conn, $query);
			if ($F_Q){
				$message["valid"] = "true";
				$message["sending"] = "true";
			}else{
				$message["valid"] = "true";
				$message["sending"] = "false";
				$query = "DELETE FROM projects WHERE ID='$inserted'";
				mysqli_query($conn, $query);
			}
		}else{
			$message["valid"] = "true";
			$message["sending"] = "false";
		}

		echo json_encode($message);

	}else{
		$message["valid"] = "false";
		$message["sending"] = "false";
		echo json_encode($message);
	}
}


}

 ?>