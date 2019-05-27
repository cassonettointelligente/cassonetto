<?php
	include "db.php";
	$json = file_get_contents ('php://input');
	$values = json_decode($json,true);

	if ($values["incendio"] == 1) {
		$stato = "on";
	}else{
		$stato = "off";
	}
	$queryinserimento = "INSERT into azioni_cassonetto(azione,stato,id_cassonetto) VALUES('incendio','$stato',1)";
	mysqli_query($sqlconn,$queryinserimento);
?>
