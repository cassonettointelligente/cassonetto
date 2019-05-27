<?php

include "db.php"; 

session_start();

$rfid = $_SESSION['rfid'];

$years = array();

$query = "SELECT distinct extract(year from giorno_e_ora) as giorno_e_ora FROM operazione WHERE rfid_utente = '$rfid';";

$res = mysqli_query($sqlconn, $query);

while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
    array_push($years, ((int) $row["giorno_e_ora"]));
}

echo json_encode($years);

?>
