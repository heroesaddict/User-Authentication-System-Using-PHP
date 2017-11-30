<?php
	$page_title = "Login Page"; 
	include_once "partials/headers.php";
	include_once "partials/parseLogin.php";
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
		  		<input type="checkbox" value= "yes" name="remember">Remember Me
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