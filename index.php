<?php
	$page_title = "User Authentication - Homepage"; 
	include_once "partials/headers.php";
?>
    <main role="main" class="container">

      <div class="flag">
        <h1>User Authentication System Using PHP</h1>
        <p class="lead">Learn to code a login and registration system with PHP.<br>
        Enhance your PHP skill and make more cash.</p>
        <?php if(!isset($_SESSION['username'])) : ?>
			<p class ="lead">You are not currently sign in <a href="login.php">Login</a> Not yet a member?<a href="signup.php">Sign up</a></p>
	  	<?php else: ?>
			<p class ="lead">You are logged in as <?php if(isset($_SESSION['username'])) echo $_SESSION['username'] ?> <a href="logout.php">Logout</a></p>
	  	<?php endif ?>

      </div>
      
    </main><!-- /.container -->
<?php 
	include_once "partials/footers.php";
 ?>


