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
	// var_dump($_GET['id_login']);
	$login = $_SESSION['id_user_login'];


if (isset($_SESSION['id_user_login'])){
	if (isset($_POST['edit'])){

		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		$full_name = htmlspecialchars($_POST['full_name']);
		$f_name = htmlspecialchars($_POST['f_name']);
		$l_name = htmlspecialchars($_POST['l_name']);
		$phone = htmlspecialchars($_POST['phone']);
		$img_data = htmlspecialchars($_POST['img_data']);
		$img_ori = $_POST['img_ori'];
		$ID = $_POST['ID'];

		$message = array();
		//cek apakah imagenya kosong ?
		if ($img_data == ""){

			$query = "UPDATE users SET first_name='$f_name',last_name='$l_name',full_name='$full_name',username='$username',password='$password',telp_number='$phone',profile='$img_ori' WHERE ID='$login'";
			try {
				$Q = mysqli_query($conn, $query);
				if ($Q){
					$message["valid"] = "true";
					$message["sending"] = "true";
				}else{
					$message["valid"] = "true";
					$message["sending"] = "false";
					$message["query"] = $query;

				}
			} catch (Exception $e) {
				$message["valid"] = "true";
				$message["sending"] = "false";
				$message["query"] = $query;
				$message["error"] = $e;
			}
			

		}else{

			//membuat file image baru
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $random_string = '';
		  
		    for ($i = 0; $i < 10; $i++) {
		        $index = rand(0, strlen($characters) - 1);
		        $random_string .= $characters[$index];
		    }

		    $output_file = "media/".$random_string.".jpg";
		    $file_handler = fopen($output_file, 'wb');
		    fwrite($file_handler, base64_decode($img_data));
		    fclose($file_handler);

		    $img_f_name = $random_string.".jpg";

		    $query = "UPDATE users SET ID='$ID',first_name='$f_name',last_name='$l_name',full_name='$full_name',username='$username',password='$password',telp_number='$phone',profile='$img_f_name' WHERE ID='$login'";

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
		}
		echo json_encode($message);

	}else{
		$data = get_data("users", $_SESSION['id_user_login'], "ID");
		echo json_encode($data);
	}
}

}

?>