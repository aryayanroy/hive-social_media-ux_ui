<?php
    try{
		$db_name = "mysql:host=localhost;dbname=hive";
		$username = "root";
		$password = "";
		$conn = new PDO($db_name, $username, $password);
	}catch(PDOException $e){
		die("Connection failed:".$e->getMessage());
	}
?>