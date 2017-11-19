<?php


//add our database connection script
include_once 'resource/Database.php';

include_once 'resource/utilities.php';


//process the form
if(isset($_POST['passwordResetBtn'])) {


	//initialize an array to store any error message from the form
	$form_errors = array();

	//form validation / whitelisting
	$required_fields = array('email', 'new_password', 'confirm_password');

	//call the function to check empty field and merge the return data into form_errors array
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));

	//fields that requires checking for minimum length
	$field_to_check_length = array('new_password' => 6, 'confirm_password' => 6);

	//call the function to check for minimum length
	$form_errors = array_merge($form_errors, check_min_length($field_to_check_length));

	//email validation / merge the return data into form_error array
	$form_errors = array_merge($form_errors, check_email($_POST));
	

	//check if error array is empty, if yes, process form data and insert record
	if(empty($form_errors)) {
		//collect form data
		$email = $_POST['email'];
		$new_password = $_POST['new_password'];
		$confirm_password = $_POST['confirm_password'];

		//check if new password and confirm password is the same
		if($new_password != $confirm_password) {
			$result = "<p style='color: red; padding: 20px; border: 1px solid gray;'>New Password and Confirm Password doesn't match</p>";
		} else {
			try{
				//create SQL insert statement
				$sqlInsert = "SELECT email FROM users WHERE email = :email";

				//used PDO prepare to sanitize data
				$statement = $db->prepare($sqlInsert);
				//execute query
				$statement->execute(array(':email' => $email));	
				//check if one new row was created
				if($statement->rowCount() == 1)	{

					//hashing the password
					$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

					//sql statement to update password
					$sqlUpdate = "UPDATE users SET password = :password WHERE email = :email";

					//used PDO prepare to sanitize data
					$statement = $db->prepare($sqlUpdate);

					//update database
					$statement->execute(array(':password' => $hashed_password,':email' => $email));	

					$result = "<p style = 'padding: 20px; border: 1px solid gray; color: green;'>Password reset successful!</p>";
				} else {
					$result = "<p style = 'padding: 20px; border: 1px solid gray; color: red;'>The email address provided doesn't exist in the database. Please try again...</p>";
				}	
		
			}catch (PDOException $ex){
			
				$result = "<p style = 'padding: 20px; border: 1px solid gray; color: red;'>An error occurred: ".$ex->getMessage()."</p>";

			}
		}
	}else{
	 	if(count($form_errors) == 1){
	 		$result = "<p style='color: red;'>There is one error in the form. </p>";
	 	}else{
			$result = "<p style='color: red;'>There were " . count($form_errors) . " errors in the form.</p>";
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
<h3>Password Reset Form</h3>

<pre>
	<?php print_r($_POST); ?>
</pre>

<?php if(isset($result)) echo $result; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>

<form method="post" action="" autocomplete="off">
	<table>
		<tr><td>Email:</td><td><input type="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" name="email"></input></td></tr>
		<tr><td>New Password:</td><td><input type="password" value="<?php if(isset($_POST['new_password'])) echo $_POST['new_password'] ?>" name="new_password" ></input></td></tr>
		<tr><td>Confirm Password:</td><td><input type="password" value="<?php if(isset($_POST['confirm_password'])) echo $_POST['confirm_password'] ?>" name="confirm_password"></input></td></tr>
		<tr><td></td><td><input style="float:right;" type="submit" name="passwordResetBtn" value="Reset Password"></input></td></tr>
	</table>
</form>

<p><a href="index.php">Back to Homepage</a></p>

</body>
</html>