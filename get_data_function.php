<?php 
require 'conn.php';

function get_data($table, $key_value, $key_param){
	$query = NULL;
	$arr = array();

	if ($key_value != 0 && $key_value != -1 && !is_null($key_value)){
		$query = "SELECT * FROM ".$table." WHERE ".$key_param." = ".$key_value."";
	}

	if ($query != NULL){
		global $conn;
		// echo($query);
		$Q = mysqli_query($conn, $query);
		// echo $query;
		// echo($query);
		// echo(mysqli_error($conn));
		while ($fetch = mysqli_fetch_assoc($Q)) {
			$arr[] = $fetch;
		}

		return $arr;
	}else{
		return $arr;
	}
}
 ?>