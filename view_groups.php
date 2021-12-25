<?php 
session_start();
require 'get_data_function.php';

// Cek login
if (isset($_SESSION['id_user_login'])){
	if (!isset($_GET['get']) || !isset($_GET['data'])){
		$projects_user = array();
		// Get data untuk member sebgai kunci tabel project
		$data_members = get_data("members", $_SESSION['id_user_login'] ,"FK_Users");
		// var_dump($data_members);
		// Pencarian project berdasar ID members
		// cleaning data members
		for ($i=0; $i < count($data_members); $i++) { 
			if (count($projects_user) == 0){
				$projects_user[$i] = $data_members[$i];
			}else{
				$same = 0;
				for ($j=0; $j < count($projects_user); $j++) { 
					if ($data_members[$i]["FK_Projects"] == $projects_user[$j]["FK_Projects"]){
						$same += 1;
					}
				}
				if ($same == 0){
					$projects_user[$i] = $data_members[$i];
				}
			}
		}

		// var_dump($data_members);
		echo json_encode($projects_user);
	}
	else if (isset($_GET['get']) && isset($_GET['data'])){
		if ($_GET['get'] == "FK_Projects") {
			$members = get_data("members", $_GET['data'], "FK_Projects");
			$members_project = array();
			for ($i=0; $i < count($members); $i++) { 
				if ($i == 0) {
					$members_project[$i] = $members[$i];
				}else{
					$same = 0;
					for ($j=0; $j < count($members_project); $j++) { 
						if ($members[$i]["FK_Projects"] == $members_project[$j]["FK_Projects"]) {
							$same += 1;
						}
					}
					if ($same == 0){
						$members_project[$i] = $members[$i];
					}
				}
			}
			echo json_encode($members_project);
		}
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

 ?>