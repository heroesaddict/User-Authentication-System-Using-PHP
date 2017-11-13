<?php 

$username = 'root';
$dsn = 'mysql:host=localhost; dbname=register';
$password = '';


//catch PDO connection error
try{
	//create an instance of PDO class with required parameter
	$db = new PDO($dsn, $username, $password);

	//set PDO mode error to exception
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//display success message
	//echo "Connected to the register database!";

}catch(PDOException $ex) {
	//display error message
	echo "Connection failed! <br/>".$ex->getMessage();
}