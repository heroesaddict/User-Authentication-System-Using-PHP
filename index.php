
<?php include_once 'resource/session.php'; ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Homepage</title>
</head>
<body>

<h2>User Authentication System Using PHP</h2><hr>
<h3>My Homepage</h3><hr>

<?php include_once 'resource/Database.php' ?>

<?php if(!isset($_SESSION['username'])) : ?>
	<p>You are not currently sign in <a href="login.php">Login</a> Not yet a member?<a href="signup.php">Sign up</a></p>
<?php else: ?>
	<p>You are logged in as <?php if(isset($_SESSION['username'])) echo $_SESSION['username'] ?> <a href="logout.php">Logout</a></p>
<?php endif ?>
</body>
</html>