<?php 

/*


*/

function check_empty_fields($required_fields_array) {
	//initialize an array to store any error message from the form
	$form_errors = array();

	

	//loop through the required field array and populate the form error array
	foreach($required_fields_array as $name_of_field){
		//echo $_POST[$name_of_field];
		
		if(!isset($_POST[$name_of_field])  || $_POST[$name_of_field]== NULL) {
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

	$errors = "<p><ul style='color: red;'>";

	//loop through error array and display all items in a list
	foreach ($form_errors_array as $the_error) {
		$errors .= "<li> {$the_error} </li>";
	}
	$errors .= "</ul></p>";
	return $errors;
}










 ?>