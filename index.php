<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Homepage</title>
</head>
<body>

<h2>User Authentication System Using PHP</h2><hr>
<h3>Homepage</h3><hr>

<?php include_once 'resource/Database.php' ?>

<p>You are not currently sign in <a href="login.php">Login</a> Not yet a member?<a href="signup.php">Sign up</a></p>
<p>You are logged in as {username} <a href="logout.php">Logout</a></p>

</body>
</html>