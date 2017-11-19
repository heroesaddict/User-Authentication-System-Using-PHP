<?php


//add our database connection script
include_once 'resource/Database.php';

include_once 'resource/utilities.php';


//process the form
if(isset($_POST['signupBtn'])) {

	//initialize an array to store any error message from the form
	$form_errors = array();

	//form validation / whitelisting
	$required_fields = array('email', 'username', 'password');

	//call the function to check empty field and merge the return data into form_errors array
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));

	//fields that requires checking for minimum length
	$field_to_check_length = array('username' => 4, 'password' => 6);

	//call the function to check for minimum length
	$form_errors = array_merge($form_errors, check_min_length($field_to_check_length));

	//email validation / merge the return data into form_error array
	$form_errors = array_merge($form_errors, check_email($_POST));

	//collect form data
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['password'];


	if(checkDuplicateEntries('users', 'username', $username, $db)){
		$result = flashMessage('Username already exist.');

	}else if(checkDuplicateEntries('users', 'email', $email, $db)){
		$result = flashMessage('Email already exist.');

	//check if error array is empty, if yes, process form data and insert record
	} else if(empty($form_errors)) {
		
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
				$result = flashMessage("Registration successful!", "Pass");
			}	
		//ex. duplicate unique fields like username, email....
		}catch (PDOException $ex){
		
			$result = flashMessage("An error occurred: " . $ex->getMessage());

		}

	} else {

		if(count($form_errors) == 1){
			$result = flashMessage("There was an error in the form.");
		} else {
			$result = flashMessage("There were " . count($form_errors) . " errors in the form. ");
		}
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

<pre>
	<?php print_r($_POST); ?>
</pre>

<?php if(isset($result)) echo $result; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>

<form method="post" action="" autocomplete="off">
	<table>
		<tr><td>Email:</td><td><input type="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" name="email"></input></td></tr>
		<tr><td>Username:</td><td><input type="text" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" name="username" ></input></td></tr>
		<tr><td>Password:</td><td><input type="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" name="password"></input></td></tr>
		<tr><td></td><td><input style="float:right;" type="submit" name="signupBtn" value="Signup"></input></td></tr>
	</table>
</form>

<p><a href="index.php">Back to Homepage</a></p>

</body>
</html>