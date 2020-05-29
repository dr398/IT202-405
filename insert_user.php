<?php
require("config.php);

$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
try{
	$db = new PDO($connection_string, $dbuser, $dbpass);
	$stmt = $db->prepare("INSERT INTO Users (email) VALUES (:email)");
	$r = $stmt->execute(array(
	     "email"=>"test@test.com"
	));
	echo var_export($stmt->errorInfo(), ture);
	echo var_export($r, true);
}
catch (exception $e){
	echo $e->getMessage();
}
?>