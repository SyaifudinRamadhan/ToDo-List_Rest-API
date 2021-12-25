<?php 
session_start();
require 'conn.php';
require 'get_data_function.php';
// $_SESSION['id_user_login'] = 3;

if (isset($_SERVER['HTTP_ORIGIN'])) {
    // should do a check here to match $_SERVER['HTTP_ORIGIN'] to a
    // whitelist of safe domains
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

if(isset($_GET['id_login'])){
	$_SESSION['id_user_login'] = $_GET['id_login'];

// Cek login ke sistem dahulu
if (isset($_SESSION['id_user_login'])){
	// Bagian indexing data project ada dua bagian
	// 1. Meembaca data project berdasar user yang login
	// 2. Membaca data project berdasar ID task, ID members

	// Membaca data project berdasar user yang login
	if (!isset($_GET['get']) || !isset($_GET['data'])){
		$data_projects = array();
		$projects_user = array();
		// Get data untuk member sebgai kunci tabel project
		$data_members = get_data("members", $_SESSION['id_user_login'] ,"FK_Users");
		// var_dump($data_members);
		// Pencarian project berdasar ID members
		// cleaning data members
		$index = 0;
		for ($i=0; $i < count($data_members); $i++) { 
			if (count($projects_user) == 0){
				$projects_user[$index] = $data_members[$i];
				$index++;
			}else{
				$same = 0;
				for ($j=0; $j < count($projects_user); $j++) { 
					if ($data_members[$i]["FK_Projects"] == $projects_user[$j]["FK_Projects"]){
						$same += 1;
					}
				}
				if ($same == 0){
					$projects_user[$index] = $data_members[$i];
					$index++;
				}
			}
		}

		// var_dump($projects_user);

		for ($i=0; $i < count($projects_user); $i++) { 
			$data_project = get_data("projects", $projects_user[$i]["FK_Projects"], "ID");
			$data_projects[$i] = $data_project[0];
		}
		// var_dump($data_projects);
		echo(json_encode($data_projects));
	}
	else if (isset($_GET['get']) && isset($_GET['data'])){
		try {
			//jika mengambil details 
			if ($_GET['get'] == 'detail'){
				$data_project = get_data("projects", $_GET['data'], "ID");
				echo json_encode($data_project);
			}
			// Ambil data member
			else{
				$data_projects = array();
				$member = get_data("members", $_GET['data'], $_GET['get']);
				for ($i=0; $i < count($member); $i++) { 
					$tmp = get_data("projects", $member[$i]["FK_Projects"], "ID")[0];
					$same = 0;
					for ($j=0; $j<count($data_projects); $j++){
						if ($data_projects[$j]['ID'] == $tmp['ID']){
							$same++;
						}
					}
					// $data_projects[$i] = get_data("projects", $member[$i]["FK_Projects"], "ID")[0];
					if ($i == 0){
						array_push($data_projects,$tmp);
					}else{
						if ($same == 0){
							array_push($data_projects,$tmp);
						}
					}
				}
				echo json_encode($data_projects);
			}
			// var_dump($data_projects);
		} catch (Exception $e) {
			$data_projects = array();
			var_dump($data_projects);
			echo(json_encode($data_projects));
		}
	}
	else{
		$data_projects = array();
		var_dump($data_projects);
		echo(json_encode($data_projects));
	}
}else{
	$data_projects = array();
	var_dump($data_projects);
	echo(json_encode($data_projects));
}

}

else{
	$message = array();
	$message['status'] = "success";
	$message['content'] = "Test API";

	echo json_encode($message);
}

 ?>