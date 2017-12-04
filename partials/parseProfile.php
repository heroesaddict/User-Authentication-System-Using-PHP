<?php 

if (isset($_SESSION['id'])) {
	$id = $_SESSION['id'];


	$sqlQuery = "SELECT * FROM users WHERE id = :id";
	$statement = $db->prepare($sqlQuery);
	$statement->execute(array(':id' => $id));

	while($result = $statement->fetch()){
		$username = $result['username'];
		$email = $result['email'];
		$date_joined = strftime("%b %d, %Y", strtotime($result['join_date']));
	}

	$encode_id = base64_encode("encodeuserid{$id}");
}


?>