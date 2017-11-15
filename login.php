<?php 

include_once 'resource/session.php';
include_once 'resource/Database.php';

 ?>


<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Login Page</title>
</head>
<body>

<h2>User Authentication System </h2><hr>
<h3>Login Form</h3>

<form method="post" action="">
	<table>
		<tr><td>Username:</td><td><input type="text" value=""></input></td></tr>
		<tr><td>Password:</td><td><input type="password" value=""></input></td></tr>
		<tr><td></td><td><input style="float:right;" type="submit" name="loginBtn" value="Signin"></input></td></tr>
	</table>
</form>

<p><a href="index.php">Back to Homepage</a></p>

</body>
</html>