<?php 
	include_once "partials/headers.php";
	include_once "partials/parseProfile.php";
	$page_title = "Edit Profile"; 
 ?>

 <div class="container">
 	<section class="col col-lg-7">

		<h2>Edit Profile</h2>
		<div>
			<?php if(isset($result)) echo $result; ?>
			<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
		</div>
		<div class="clearfix"></div>

		<?php if(!isset($_SESSION['username'])): ?>
			<p class="lead"> You are not authorized to view this page <a href="login.php">Login</a>Not yet a member? <a href="signup.php"></a>Signup</p>

		<?php else: ?>

			<form method="post" action="" enctype="multipart/form-data">
				<div class="form-group">
					<label for="emailField">Email</label>
					<input type="text" name="email" class="form-control" id="emailField" value="<?php if(isset($email)) echo $email; ?>">
				</div>

				<div class="form-group">
					<label for="usernameField">Username</label>
					<input type="text" name="username" class="form-control" id="usernameField" value="<?php if(isset($username)) echo $username; ?>">
				</div>

				<div class="form-group">
					<label for="fileField">Avatar</label><br>
					<input type="file" name="avatar" id="fileField" >
				</div>

				<input type="hidden" name="hidden_id" value="<?php if(isset($id)) echo $id; ?>">
				<button type="submit" name="updateProfileBtn" class="btn btn-primary pull-right" value="Update">Update Profile</button>

			</form>
		<?php endif ?>

 	</section>

 	<p><a href="index.php">Back</a></p>

 </div>


<?php 
	include_once "partials/footers.php";
 ?>