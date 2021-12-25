<?php 

$host = "remotemysql.com:3306";
// $username = "sql6456677";
// $password = "TWJq1hwlUn";
// $db_name = "sql6456677";
$username = "uFL8I9wbLT";
$password = "4WMN0XbNjN";
$db_name = "uFL8I9wbLT";
// $host = "sql110.epizy.com";
// $username = "epiz_30524316";
// $password = "O5pW6rsEbuu";
// $db_name = "epiz_30524316_project_manager_db";

$conn = mysqli_connect($host,$username, $password, $db_name);

if (!$conn){
	echo("Koneksi gagal");
	exit();
}

 ?>