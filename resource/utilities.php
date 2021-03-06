<?php 

/*


*/

function check_empty_fields($required_fields_array) {
	//initialize an array to store any error message from the form
	$form_errors = array();

	

	//loop through the required field array and populate the form error array
	foreach($required_fields_array as $name_of_field){
		//echo $_POST[$name_of_field];
		
		if(!isset($_POST[$name_of_field])  || $_POST[$name_of_field] == NULL) {
			$form_errors[] = $name_of_field . " is a required field.";

			//$a = count($form_errors);
			//echo $form_errors[$a-1];
		}
		
	}
	return $form_errors;
}


function check_min_length($fields_to_check_length){
	//initialize an array to store any error message from the form
	$form_errors = array();

	foreach ($fields_to_check_length as $name_of_field => $minimum_length_required) {
		if(strlen(trim($_POST[$name_of_field])) < $minimum_length_required) {
			$form_errors[] = $name_of_field . " is too short, must be {$minimum_length_required} characters long.";
		}
	}
	return $form_errors;
}

function check_email($data){
	//initialize an array to store any error message from the form
	$form_errors = array();

	$key = 'email';
	//check if the key'email' exist in the data array
	if(array_key_exists($key, $data)){
		//check if the email field has a value
		if($_POST[$key] != null){
			//remove all illegal characters from email
			$key = filter_var($key, FILTER_SANITIZE_EMAIL);

			//check if input is a valid email address
			if(filter_var($_POST[$key], FILTER_VALIDATE_EMAIL) === FALSE){
				$form_errors[] = $key . " is not a valid email address";
			}

		}
	}
	return $form_errors;
}

function show_errors($form_errors_array){

	$errors = "<div class = 'alert alert-danger'><ul style='color: red;'>";

	//loop through error array and display all items in a list
	foreach ($form_errors_array as $the_error) {
		$errors .= "<li> {$the_error} </li>";
	}
	$errors .= "</ul></div>";
	return $errors;
}


function flashMessage($message, $PassorFail = "Fail"){
	if($PassorFail === "Pass"){
		$data = "<div class = 'alert alert-success'>{$message}</div>";
	} else {
		$data = "<div class = 'alert alert-danger'>{$message}</div>";
	}
	return $data;
}


function redirectTo($page){
	header("Location: {$page}.php"); //or header("Location: " .$page. ".php");
}


function checkDuplicateEntries($tableName, $columnName, $value, $db){
	try {
		//$sqlQuery = "SELECT * FROM users WHERE username = :username";
		$sqlQuery = "SELECT " .$columnName. " FROM " .$tableName. " WHERE " .$columnName. "=:" .$columnName;
		$statement = $db->prepare($sqlQuery);
		$statement->execute(array(':' .$columnName => $value));

		if($row = $statement->fetch()){
			return true;
		}
		return false;
	
	}catch (PDOException $Ex) {

	}

}

function rememberMe($user_id) {
	$encryptCookieData = base64_encode("revilomik{$user_id}");
	//cookie set to expire in 30 days
	setcookie("rememberUserCookie", $encryptCookieData, time()+60*60*24*100, "/");
}

function isCookieValid($db) {
	$isValid = false;

	if(isset($_COOKIE['rememberUserCookie'])){
		//decode cookie and extract use_id
		$decryptCookieData = base64_decode($_COOKIE['rememberUserCookie']);
		$user_id = explode("revilomik", $decryptCookieData);
		$userID = $user_id[1];

		//check if user_id retrieved from the cookie exist in the database
		$sqlQuery = "SELECT * FROM users WHERE id = :id";
		$statement = $db->prepare($sqlQuery);
		$statement->execute(array(':id' => $userID));

		if($row = $statement->fetch()) {
			$id = $row['id'];
			$username = $row['username'];

			//create the user session variable
			$_SESSION['id'] =$id;
			$_SESSION['username'] =$username;
			$isValid = true;

		}else{
			//cookie id is invalid so destroy session and logout user
			$isValid = false;
			signout();

		}


	}
	return $isValid;
}


function signout() {
	unset($_SESSION['username']);
	unset($_SESSION['id']);

	//destroy cookies.. if not implemented, it keeps user logged in
	if(isset($_COOKIE['rememberUserCookie'])) {
		unset($_COOKIE['rememberUserCookie']);

		setcookie('rememberUserCookie', null, -1, '/');
	}

	session_destroy();
	session_regenerate_id(true);
	redirectTo('index');

}


//check if user is inactive for certain time
function guard() {
	$isValid = true;
	$inactive = 60*10; //  10 mins

	//$_SERVER['REMOTE_ADDR'] > get IP address, $_SERVER['HTTP_USER_AGENT'] > get browser details
	//encrypt md5
	$fingerprint = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

	//compare SESSION fingerprint and fingerprint
	if((isset($_SESSION['fingerprint']) && $_SESSION['fingerprint'] != $fingerprint)) {
		$isValid =false;
		signout();

	}else if(isset($_SESSION['last active']) && time() - $_SESSION['last active'] > $inactive && $_SESSION['username']) {
		$isValid - false;
		signout();

	}else {
		$_SESSION['last active'] = time();

	}

	return $isValid;
}


function isValidImage($file){
	$form_errors = array();

	//split filename into an array using the dot(.)
	$part = explode(".", $file);
	//targetting the last element in the array
	$extension = end($part);

	switch (strtolower($extension)) {
		case 'jpg':

		case 'gif':

		case 'bmp':

		case 'png':



		return $form_errors;

	}

	$form_errors[] = $extension . " is not a valid image extension";

	return $form_errors;

}

function uploadAvatar($username){

	$isImageMoved = false;

	if($_FILES['avatar']['tmp_name']){

		//file in temporary location
		$temp_file = $_FILES['avatar']['tmp_name'];  //temp_file C:\wamp64\tmp\phpBA32.tmp

		echo "temp_file ".$temp_file."<br>";
		$ds = DIRECTORY_SEPARATOR; //  '/'
		$avatar_name = $username.".jpg";

		$path = "uploads".$ds.$avatar_name; //uploads/username.jpg
		echo "path ".$path."<br>";

		if(move_uploaded_file($temp_file, $path)){
			$isImageMoved = true;
		}

	}

	return $isImageMoved;
}

 ?>