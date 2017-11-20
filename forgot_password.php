<?php 
	include_once "partials/headers.php";
	include_once "partials/parseForgotPassword.php";
	$page_title = "Reset Password Page"; 
 ?>

 <div class="container">
 	<section class="col col-lg-7">

		<h2>User Authentication System </h2><hr>
		<h3>Password Reset Form</h3>

		<?php if(isset($result)) echo $result; ?>
		<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>

		<form method="post" action="">
			<div class="form-group">
		    <label for="usernameInput">Email Address</label>
		    <input type="text" class="form-control" id="emailInput" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" placeholder="Enter email">
		  </div>
		  <div class="form-group">
		    <label for="newpasswordInput">New Password</label>
		    <input type="password" class="form-control" id="newpasswordInput" value="<?php if(isset($_POST['new_password'])) echo $_POST['new_password'] ?>"name="new_password" placeholder="Enter new password">
		  </div>
		  <div class="form-group">
		    <label for="confirm passwordInput">Confirm Password</label>
		    <input type="password" class="form-control" id="confirmpasswordInput" value="<?php if(isset($_POST['confirm_password'])) echo $_POST['confirm_password'] ?>"name="confirm_password" placeholder="Enter Confirm Password">
		  </div>
		  <div class="form-group">
		  	<button class="float-right" class="btn btn-primary" name="passwordResetBtn" type="submit" class="btn btn-primary" value="Reset Password">Reset Password</button>
		  </div>
		</form>
		<br><br>

		<p><a href="index.php">Back to Homepage</a></p>

 	</section>
 </div>


<?php 
	include_once "partials/footers.php";
 ?>