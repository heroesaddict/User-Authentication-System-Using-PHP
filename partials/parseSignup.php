<?php


//add utilities.php
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
				
							//call sweet alert
				$result = "<script type=\"text/javascript\">
					
						swal({
						  title: \"Congratulations!\",
						  text: \"Registration Completed Successfully!\",
						  icon: \"success\",
						  button: \"Thank You!\",
						});
					</script>";
				
			
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
