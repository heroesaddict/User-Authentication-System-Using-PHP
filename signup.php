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
				//clear inputs
				//use javascript
			
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


<?php 
	include_once "partials/headers.php";
	$page_title = "Registration Page"; 
 ?>

 <div class="container">
 	<section class="col col-lg-7">
 		<h2>Registration Form</h2>
<!-- 
		<pre>
			<?php print_r($_POST); ?>
		</pre> -->

		<?php if(isset($result)) echo $result; ?>
		<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>

		<form method="post" action="">
			<div class="form-group">
		    <label for="usernameInput">Email Address</label>
		    <input type="text" class="form-control" id="emailInput" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" aria-describedby="emailHelp" placeholder="Enter email">
		    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
		  </div>
		  <div class="form-group">
		    <label for="usernameInput">Username</label>
		    <input type="text" class="form-control" id="usernameInput" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" placeholder="Enter username">
		  </div>
		  <div class="form-group">
		    <label for="passwordInput">Password</label>
		    <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Enter Password">
		  </div>
		  <button type="submit" class="btn btn-primary" name="signupBtn" value="Signin" >Register</button>
		 </form>

		<br><br>
		<p><a href="index.php">Back to Homepage</a></p>

 	</section>
 </div>





<?php 
	include_once "partials/footers.php";
 ?>