<?php

include "db.php";

$json = file_get_contents('php://input');
$values = json_decode($json, true);

$stage = $values["stage"];

if ($stage == "1") {

	$username = $values["username"];
	$password = $values["password"];

	$query = "SELECT * FROM utente WHERE username = '$username' and password = '$password'";

	$result = mysqli_query($sqlconn, $query);

	if ( usernameWrong($username, $sqlconn) == false && passwordWrong($password, $sqlconn) == false ){
		$session_id = $username . date("Ymd");
		$session_id_hash = hash("md5", $session_id);
		if (mysqli_num_rows( mysqli_query($sqlconn, "SELECT * FROM sessions WHERE session_id = '$session_id_hash'") ) == 0) {
			mysqli_query($sqlconn, "INSERT INTO sessions VALUES ('$username', '$session_id_hash')");
		}
		$response = json_encode(array( "status" => "success", "session_id" => $session_id_hash ));
		echo $response;
	}

} else if ($stage == "2") {

	$session_id = $values["session_id"];

	$result = mysqli_query($sqlconn, "SELECT * FROM sessions WHERE Session_id = '$session_id'");

	$username = mysqli_fetch_array($result)["Username"];

	$userdata = mysqli_query($sqlconn, "SELECT * FROM users WHERE Username = '$username'");
	$userdata_array = mysqli_fetch_array($userdata);

	$nome = $userdata_array["Nome"];
	$cognome = $userdata_array["Cognome"];
	$email = $userdata_array["Email"];

	if (mysqli_num_rows($result) > 0) {
		$response = json_encode( array( "status" => "success", "nome" => $nome, "cognome" => $cognome, "email" => $email, "username" => $username ) );
		echo $response;
	} else {
		$response = json_encode( array( "status" => "error" ) );
		echo $response;
	}

}

function passwordWrong($password, $sqlconn) {
	$exists = "SELECT email FROM utente WHERE password = '$password'";

	$result = mysqli_query($sqlconn, $exists);

	if (mysqli_num_rows($result) == 0 ) {
		$response = json_encode(array( "status" => "error", "error" => "password_wrong" ));
		echo $response;
		return true;
	} else {
		return false;
	}
}

function usernameWrong($username, $sqlconn) {
	$exists = "SELECT Username FROM utente WHERE username = '$username'";

	$result = mysqli_query($sqlconn, $exists);

	if (mysqli_num_rows($result) == 0 ) {
		$response = json_encode(array( "status" => "error", "error" => "username_wrong" ));
		echo $response;
		return true;
	} else {
		return false;
	}
}

?>