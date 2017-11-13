<?php
//add our database connection script
include_once 'resource/Database.php';

//process the form
if(isset($_POST['email'])) {
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['password'];

	//hashing the password
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	
	try{
		//create SQL insert statement
		$sqlInsert = "INSERT INTO users (username, email, password, join_date) VALUES (:username, :email, :password, now())";

		//used PDO prepare to sanitize data
		$statement = $db->prepare($sqlInsert);
		//add the data to the database
		$statement->execute(array(':username' => $username, ':email' => $email, ':password' => $hashed_password));	
		//check if one new row was created
		if($statement->rowCount() == 1)	{
			$result = "<p style = 'padding: 20px; color: green;'>Registration successful!</p>";
		}	
	
	}catch (PDOException $ex){
	
		$result = "<p style = 'padding: 20px; color: red;'>An error occurred: ".$ex->getMessage()."</p>";

	}
}

?>


<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Register Page</title>
</head>
<body>

<h2>User Authentication System </h2><hr>
<h3>Registration Form</h3>

<?php
	if(isset($result)) echo $result;
?>

<form method="post" action="">
	<table>
		<tr><td>Email:</td><td><input type="email" value="" name="email"></input></td></tr>
		<tr><td>Username:</td><td><input type="text" value="" name="username"></input></td></tr>
		<tr><td>Password:</td><td><input type="password" value="" name="password"></input></td></tr>
		<tr><td></td><td><input style="float:right;" type="submit" name="signupBtn" value="Signup"></input></td></tr>
	</table>
</form>

<p><a href="index.php">Back to Homepage</a></p>

</body>
</html>