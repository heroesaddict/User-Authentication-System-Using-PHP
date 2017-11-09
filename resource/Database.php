<?php 

$username = 'root';
$dsn = 'mysql:host=localhost; dbname=register';
$password = '';


//catch PDO connection error
try{
	$db = new PDO($dsn, $username, $password);
	//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	echo "Connected to the register database!";

}catch(PDOException $ex) {
	echo "Connection failed! <br/>".$ex->getMessage();
}