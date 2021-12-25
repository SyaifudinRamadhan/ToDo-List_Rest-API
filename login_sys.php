<?php 

require 'conn.php';

function login($username, $password){
	// Cek username
	global $conn;
	$query = "SELECT * FROM users WHERE username = '$username'";
	$usr_check = mysqli_query($conn, $query);

	// $num_usr = mysqli_num_rows($usr_check);
	$get_usr = array();
	while($fetch = mysqli_fetch_assoc($usr_check)){
		$get_usr[] = $fetch;
	}

	if (count($get_usr) == 0 ){
		return NULL;
	}else{
		for ($i=0; $i <count($get_usr) ; $i++) { 
			if ($get_usr[$i]["password"] == $password){
				// $i = count($get_usr);
				return $get_usr[$i]["ID"];
			}
		}
		return (-1);
	}
}

function sign_up($username, $password, $f_name, $l_name, $full_name, $telp_number){
	$query = "INSERT INTO users (ID, first_name, last_name, full_name, username, password, telp_number, profile) VALUES(0, '$f_name', '$l_name', '$full_name', '$username', '$password', '$telp_number', '-')";

	global $conn;
	try {
		$Q = mysqli_query($conn, $query);
		echo(mysqli_error($conn));
	} catch (Exception $e) {
		var_dump($e);
	}
	$affected = mysqli_affected_rows($conn);

	if ($affected == 0){
		return (-1);
	}else if($affected == -1){
		return NULL;
	}else{
		$result = login($username, $password);
		return $result;
	}
}

 ?>