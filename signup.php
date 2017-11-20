<?php 
	include_once "partials/headers.php";
	include_once "partials/parseSignup.php";
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