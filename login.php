<?php 

include_once 'resource/session.php';
include_once 'resource/Database.php';
include_once 'resource/utilities.php';

if(isset($_POST['loginBtn'])){
	//array to hold errors
	$form_errors = array();

	//validate
	$required_fields = array('username', 'password');

	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));

	if(empty($form_errors)){

		//collect form data
		$user = $_POST['username'];
		$password = $_POST['password'];

		//check if user exist in database
		$sqlQuery = "SELECT * FROM users WHERE username = :username";
		$statement = $db->prepare($sqlQuery);
		$statement->execute(array(':username' => $user));
		if($statement->rowCount() == 1)	{
				
		}else {
			$result = flashMessage("Username is not in database. Please register...");
			//redirectTo("signup");
		}
		while($row = $statement->fetch()){
			$id = $row['id'];
			$hashed_password = $row['password'];
			$username = $row['username'];

			if(password_verify($password, $hashed_password)){
				$_SESSION['id'] = $id;
				$_SESSION['username'] = $username;
				redirectTo("index");
			}else{
				$result = flashMessage("Invalid password.");
			}

		}

	}else{
	 	if(count($form_errors) == 1){
	 		$result = flashMessage("There is one error in the form.");
	 	}else{
			$result = flashMessage("There were " . count($form_errors) . " errors in the form.");
		}
	}
}


?>


<?php
	$page_title = "Login Page"; 
	include_once "partials/headers.php";
?>

<div class="container" >
	<section class="col col-lg-7">
		<h2>Login Form</h2>
		<?php if(isset($result)) echo $result ?>
		<?php if(!empty($form_errors)) echo show_errors($form_errors)?>

		<form method="post" action="">
		  <div class="form-group">
		    <label for="usernameInput">Username</label>
		    <input type="text" class="form-control" id="usernameInput" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" placeholder="Enter username">
		  </div>
		  <div class="form-group">
		    <label for="passwordInput">Password</label>
		    <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Enter Password">
		  </div>
		  <div class="checkbox">
		  	<label>
		  		<input type="checkbox" name="remember">Remember Me
		  	</label>
		  	<button class="float-right" type="submit" class="btn btn-primary" name="loginBtn" value="Signin">Signin</button>
		  </div>
		  <div class="form-group">
		  	<a class="float-left" href="forgot_password.php">Forgot Password?</a>
		  </div>
		</form>
		<br>
		<br>

		<p><a href="index.php">Back to Homepage</a></p>

		

	</section>
	
</div> 


<?php 
	include_once "partials/footers.php";
 ?>