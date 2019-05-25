<?php
include "db.php";
$json = file_get_contents('php://input');
$values = json_decode($json, true);

$rfid = $values["rfid"];

$query = "SELECT nome FROM utente WHERE rfid = '$rfid';";

$res = mysqli_query($sqlconn, $query);

if(mysqli_num_rows($res) > 0){
	echo mysqli_fetch_array($res)["nome"];
} else {
	echo "fail";
}

?>
