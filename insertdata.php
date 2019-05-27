<?php
	include "db.php";
	$json = file_get_contents ('php://input');
	$values = json_decode($json,true);

	$tipo_di_rifiuto = $values["tipo_di_rifiuto"];
	$peso = $values["peso"];
	$rfid_utente = $values["rfid_utente"];
	$valore_ph = $values["valore_ph"];
	$queryinserimento = "INSERT INTO operazione(peso,id_cassonetto,rfid_utente,tipo_di_rifiuto,valore_ph) values($peso,1,$rfid_utente,$tipo_di_rifiuto,$valore_ph)";

	mysqli_query($sqlconn,$queryinserimento);
?>
