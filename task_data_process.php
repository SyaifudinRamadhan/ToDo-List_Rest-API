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

if (isset($_POST['edit']) or isset($_FILES['file'])){

	if (isset($_FILES['file'])){

		$ID = $_POST['key'];
		$filename = $_FILES['file']['name'];

		$name_split = explode(".", $filename);
		$extention = $name_split[count($name_split)-1];

		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $random_string = '';
		  
		    for ($i = 0; $i < 10; $i++) {
		        $index = rand(0, strlen($characters) - 1);
		        $random_string .= $characters[$index];
		    }

		$new_file_name = $random_string.".".$extention;

		// echo $new_file_name;

		$savefile = "media/".$new_file_name;
    //complete path to save file

	    if(move_uploaded_file($_FILES["file"]["tmp_name"], $savefile)) {
	        $message["valid"] = "true";

	        $query = "UPDATE task_details SET file_attachment='$new_file_name' WHERE FK_Tasks = '$ID'";
	        
	        $Q = mysqli_query($conn, $query);
	        if ($Q){
	        	$message["sending"] = "true";
	        }else{
	        	$message["sending"] = "false";
	        }
	        //upload successful
	    }else{
	        $return["valid"] = "false";
	        $return["sending"] =  "false";
	    }

		$message["test"] = isset($_POST['key']);
		// var_dump($_FILES['file']);
		echo json_encode($message);

	}else{

		$task_name = htmlspecialchars($_POST['task_name']);
		$desc = htmlspecialchars($_POST['desc']);
		$f_date = htmlspecialchars($_POST['f_date']);
		$end_date = htmlspecialchars($_POST['end_date']);
		$project_id = htmlspecialchars($_POST['project_id']);
		$file_ori = $_POST['file_ori'];
		$status = $_POST['status'];
		$ID = $_POST['ID'];

		$query = "UPDATE tasks SET task_name='$task_name',start_task='$f_date',end_task='$end_date',description='$desc',status='$status',FK_Projects='$project_id' WHERE ID = '$ID'";

		$query2 = "UPDATE task_details SET description='$desc',satuses='$status',file_attachment='$file_ori' WHERE FK_Tasks = '$ID'";

		$Q = mysqli_query($conn, $query);
		$Q2 = mysqli_query($conn, $query2);

		if ($Q){

			$message["valid"] = "true";
			$message["sending"] = "true";
			$message["query"] = $query;
			$message["test"] = isset($_FILES['file']);

		}else{

			$message["valid"] = "true";
			$message["sending"] = "false";
			$message["query"] = $query;
			$message["test"] = isset($_FILES['POST']);

		}
		echo json_encode($message);

	}

}else if(isset($_GET['delete'])){

	$ID = $_GET['delete'];

	$query = "DELETE FROM tasks WHERE ID = '$ID'";
	
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
	if(isset($_POST['task_name']) and isset($_POST['desc']) and isset($_POST['f_date']) and isset($_POST['end_date']) and isset($_POST['project_id'])){

		$task_name = htmlspecialchars($_POST['task_name']);
		$desc = htmlspecialchars($_POST['desc']);
		$f_date = htmlspecialchars($_POST['f_date']);
		$end_date = htmlspecialchars($_POST['end_date']);
		$project_id = htmlspecialchars($_POST['project_id']);

		$query = "INSERT INTO tasks(ID, task_name, start_task, end_task, description, status, FK_Projects) VALUES (0,'$task_name', '$f_date', '$end_date', '$desc', 0, '$project_id')";
		$Q = mysqli_query($conn, $query);

		if ($Q){
			$inserted = mysqli_insert_id($conn);

			$query = "INSERT INTO task_details(ID, description, satuses, file_attachment, FK_Tasks) VALUES (0,'$desc',0, '', '$inserted')";

			$F_Q = mysqli_query($conn, $query);
			if ($F_Q){
				$message["valid"] = "true";
				$message["sending"] = "true";
			}else{
				$query = "DELETE FROM tasks WHERE ID='$inserted'";
				mysqli_query($conn, $query);
				$message["valid"] = "true";
				$message["sending"] = "false";
			}
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