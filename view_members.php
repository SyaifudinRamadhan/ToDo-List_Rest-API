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
	if (!isset($_GET['get']) || !isset($_GET['data'])) {
		$projects_user = array();
		$members = array();
		$members_in_user = array();
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
		
		for ($i=0; $i < count($projects_user); $i++) { 
			$data_project_member = get_data("members", $projects_user[$i]["FK_Projects"], "FK_Projects");
			// Ridak boleh ada ID user sama dalam 1 project
			$project_members = array();
			$project_members_user = array();
			$index = 0;
			for ($j=0; $j < count($data_project_member); $j++) { 
				if ($j == 0){
					$project_members[0] = $data_project_member[$j];

					$prj_of_member = get_data("projects", $project_members[$j]["FK_Projects"], "ID")[0]["project_name"];

					$project_members_user[0] = get_data("users", $project_members[0]["FK_Users"], "ID")[0];
					$index++;

					array_push($project_members_user[$j], $prj_of_member);
				}else{
					$same = NULL;
					for ($k=0; $k < count($project_members); $k++) { 
						if ($project_members[$k]["FK_Users"] == $data_project_member[$j]["FK_Users"]) {
							$same += 1;
						}
					}
					if ($same == 0){
						$project_members[$index] = $data_project_member[$j];
						// Cari projectnnya
						$prj_of_member = get_data("projects", $project_members[$index]["FK_Projects"], "ID")[0]["project_name"];

						$project_members_user[$index] = get_data("users", $project_members[$index]["FK_Users"], "ID")[0];

						array_push($project_members_user[$index], $prj_of_member);
						$index++;
					}
				}
				// $members[$i] = $project_members;
				// $members_in_user[$i] = $project_members_user[0];
			}
			$loop = 0;
			$limit = count($project_members_user)+count($members_in_user);
			for ($k=count($members_in_user); $k < $limit; $k++) { 

				$members_in_user[$k] = $project_members_user[$loop];
				// var_dump($project_members_user[$loop]);
				$loop++;
			}
			
		}

		// var_dump($data_members);
		// echo(json_encode($members));
		// echo "\n\n";
		echo json_encode($members_in_user);
	}
	else if (isset($_GET['get']) && isset($_GET['data'])){
		if ($_GET['get'] == "FK_Projects") {
			$members = get_data("members", $_GET['data'], "FK_Projects");
			$members_project = array();
			$members_in_user = array();
			for ($i=0; $i < count($members); $i++) { 
				if ($i == 0) {
					array_push($members_project, $members[$i]);
					// $members_project[$i] = $members[$i];
					$tmp= get_data("users", $members[$i]["FK_Users"], "ID")[0];
					array_push($members_in_user, $tmp);
				}else{
					$same = 0;
					for ($j=0; $j < count($members_project); $j++) { 
						// echo($j);
						// var_dump($members_project[$j]);

						if ($members[$i]["FK_Users"] == $members_project[$j]["FK_Users"]) {
							$same += 1;
						}
					}
					if ($same == 0){
						// $members_project[$i] = $members[$i];
						array_push($members_project, $members[$i]);
						$tmp = get_data("users", $members[$i]["FK_Users"], "ID")[0];
						array_push($members_in_user, $tmp);
					}
				}
			}
			// var_dump($members);
			echo json_encode($members_in_user);
		}else if ($_GET['get'] == "FK_Tasks") {
			$members = get_data("members", $_GET['data'], "FK_Tasks");
			$members_user = array();
			
			for ($i=0; $i < count($members); $i++) { 
				$same = 0;
				$tmp = get_data("users", $members[$i]["FK_Users"], "ID")[0];
				$tmp["ID_member"] = $members[$i]["ID"];

				for ($j=0; $j<count($members_user); $j++){
					if($tmp['ID'] == $members_user[$j]['ID']){
						$same++;
					}
				}

				if ($i==0){
					array_push($members_user,$tmp);
				}else{
					if ($same == 0){
						array_push($members_user,$tmp);
					}
				}
				
			}
			// echo json_encode($members);
			echo json_encode($members_user);
		}else if($_GET['get'] == "details"){
			$details = get_data("users", $_GET['data'], "ID");
			echo json_encode($details);
		}
		// $data_user_projects = array();
		// $data_members = array();

		// $data_members = get_data("members", $_GET['data'], parse_str($_GET['get']));

		// for ($i=0; $i < count($data_user_projects); $i++) { 
		// 	$data_project = get_data("members", $data_user_projects[$i]["FK_Projects"], "FK_Projects");
		// 	$tmp = array();
		// 	for ($j=0; $j < count($data_project); $j++) { 
		// 		$tmp[$j] = get_data("users", $data_project[$j]["FK_Users"], "ID");
		// 	}
		// 	$data_members[$i] = $tmp;
		// }

		// var_dump($data_members);
		// echo(json_encode($data_members));
	}
	else{
		$data_members = array();
		var_dump($data_members);
		echo(json_encode($data_members));
	}
}else{
	$data_members = array();
	echo(json_encode($data_members));
}


}

 ?>