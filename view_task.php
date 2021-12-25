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


// Cek login
if (isset($_SESSION['id_user_login'])){
	// Untuk view task, akan emiliki 3 bagian
	// 1&2. View list task berdasarkan ID user login, dan ID project
	// 3. View detail task berdasarakan ID task
	if (isset($_GET['get']) && isset($_GET['data'])){
		if ($_GET['get'] != 'details'){
			$data_task = get_data("tasks", $_GET['data'], $_GET['get']);
			echo(json_encode($data_task));
		}
		// $member = get_data("members", $_GET['data'], parse_str($_GET['get']));
		// for ($i=0; $i < count($member); $i++) { 
		// 	$data_task[$i] = get_data("tasks", $members[$i]["FK_Task"], "ID");
		// }
		// var_dump($data_task);
		else if ($_GET['get'] == 'details'){
			$data_task = get_data("tasks", $_GET['data'], "ID");
			$sub_task = get_data("task_details", $data_task[0]["ID"], "FK_Tasks")[0];
			array_push($data_task[0],$sub_task['ID']);
			array_push($data_task[0],$sub_task['description']);
			array_push($data_task[0],$sub_task['satuses']);
			array_push($data_task[0],$sub_task['file_attachment']);
			// var_dump($data_task);
			// echo(json_encode($data_task));
			echo json_encode($data_task);
		}
	}
	else{

		$data_members = get_data("members", $_SESSION['id_user_login'], "FK_Users");
		$data_projects = array();
		
		for ($i=0; $i<count($data_members); $i++){
			$same = 0;
			$tmp = get_data("projects", $data_members[$i]["FK_Projects"], "ID")[0];
			for ($j=0; $j<count($data_projects); $j++){
				if ($tmp["ID"] == $data_projects[$j]["ID"]){
					$same++;
				}
			}

			if ($i==0){
				array_push($data_projects,$tmp);
			}else{
				if ($same == 0){
					array_push($data_projects,$tmp);
				}
			}
		}
		$data_tasks = array();
		for ($i=0; $i<count($data_projects); $i++){
			$tmp = get_data("tasks",$data_projects[$i]["ID"],"FK_Projects");
			for ($j=0; $j<count($tmp); $j++){
				array_push($tmp[$j],$data_projects[$i]["project_name"]);
				array_push($data_tasks,$tmp[$j]);
			}
		}

		// var_dump($data_task);
		echo(json_encode($data_tasks));
		
	}
	
}else{
	$data_task = array();
	echo(json_encode($data_task));
}

}

 ?>