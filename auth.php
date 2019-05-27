<?php
	include "db.php";
	$json = file_get_contents ('php://input');
	$values = json_decode($json,true);



	if (isset($values["rfid"]) and isset($values["id_cassonetto"]) and !isset($values["tipo_di_rifiuto"])) {
		$rfid = $values["rfid"];
		$id_cassonetto = $values["id_cassonetto"];
		$query = "SELECT * FROM utente WHERE rfid = '$rfid'";
		$res = mysqli_query($sqlconn,$query);
		if(mysqli_num_rows($res)>0){
			while ($row = mysqli_fetch_array($res,MYSQL_ASSOC)) {
				$nomeutente = $row['nome'];
				$caputente = $row['cap'];
			}
			$querycassonetto = "SELECT * FROM cassonetto WHERE id_cassonetto = '$id_cassonetto'";
			$resCassonetto = mysqli_query($sqlconn,$querycassonetto);
			if (mysqli_num_rows($resCassonetto)>0) {
				while ($row1 = mysqli_fetch_array($resCassonetto,MYSQL_ASSOC)) {
					$capcassonetto = $row1['cap'];
				}
				if ($caputente == $capcassonetto) {
					echo "Benvenuto $nomeutente.";
				}else{
					echo "Non puoi gettare qui i tuoi rifiuti.";
				}
			}else{
				echo "Cassonetto non ancora abilitato";
			}	
		}else{
			echo "Utente non valido.";
		}
	}

	if (isset($values["tipo_di_rifiuto"])) {
		$tipo_di_rifiuto = $values["tipo_di_rifiuto"];
		$peso = $values["peso"];
		$id_cassonetto = $values["id_cassonetto"];
		$rfid_utente = $values["rfid_utente"];
		$valore_ph = $values["valore_ph"];
		$queryinserimento = "INSERT INTO operazione(peso,rfid_cassonetto,rfid_utente,tipo_di_rifiuto,valore_ph) values($peso,$id_cassonetto,$rfid_utente,$tipo_di_rifiuto,$valore_ph)";
		if (mysqli_query($sqlconn,$queryinserimento)) {
		}
	}

	if (isset($values["incendio"])) {
		if ($values["incendio"] == 1) {
			$incendio = "Inizio incendio.";
		}else{
			$incendio = "Fine incendio.";
		}
		$id_cassonetto = $values["id_cassonetto"];
		$queryinserimento = "INSERT into azioni_cassonetto(azione,id_cassonetto) VALUES($incendio,$id_cassonetto)";
		if (mysqli_query($sqlconn,$queryinserimento)) {
		}
	}

	if (isset($values["sospensione"])) {
		if ($values["sospensione"] == 1) {
			$incendio = "Inizio sospensione.";
		}else{
			$incendio = "Fine sospensione.";
		}
		$id_cassonetto = $values["id_cassonetto"];
		$queryinserimento = "INSERT into azioni_cassonetto(azione,id_cassonetto) VALUES($sospensione,$id_cassonetto)";
		if (mysqli_query($sqlconn,$queryinserimento)) {
		}
	}
	
?>