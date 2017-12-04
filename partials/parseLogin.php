<?php 


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

		isset($_POST['remember']) ? $remember = $_POST['remember'] : $remember = "";

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

			$fingerprint = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
			$_SESSION['last active'] = time();
			$_SESSION['fingerprint'] = $fingerprint;


			if($remember === "yes") {

				rememberMe($id);

			}


			if(password_verify($password, $hashed_password)){
				$_SESSION['id'] = $id;
				$_SESSION['username'] = $username;

				//call sweet alert
				echo $welcome = "<script type=\"text/javascript\">
							swal({
							  title: \"Welcome back $user \",
							  text: \"You are now login!\",
							  icon: \"success\",
							  timer: 4000,
							  showConfirmationButton: false,
							});
							
							setTimeout(function(){
								window.location.href = \"index.php\";
							},3000);


						</script>";


				//redirectTo("index");

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