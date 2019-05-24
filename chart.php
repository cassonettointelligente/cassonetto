<?php

include "db.php";

session_start();
$json = file_get_contents('php://input');
$values = json_decode($json, true);

$rfid = $_SESSION['rfid'];

$anno = $values["anno"];

$ris_finale = array("metallo" => array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0),
                    "vetro" => array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0),
                    "indifferenziato" => array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0),
                    "umido" => array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0),
                    "plastica" => array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0),
                    "carta" => array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0),
                    "raee" => array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0)
                    );

for($mese = 1; $mese<13; $mese++){

        $query = "select tipo_di_rifiuto from operazione where extract(month from giorno_e_ora) = $mese and extract(year from giorno_e_ora) = $anno and rfid_utente = '$rfid';";

        $res = mysqli_query($sqlconn, $query);

        while ($row = $res->fetch_assoc()) {
            switch($row["tipo_di_rifiuto"]) {
                case "metallo":
                    $ris_finale["metallo"][$mese-1]++; break;
                case "vetro":
                    $ris_finale["vetro"][$mese-1]++;  break;
                case "indifferenziato":
                    $ris_finale["indifferenziato"][$mese-1]++; break;
                case "umido":
                    $ris_finale["umido"][$mese-1]++; break;
                case "plastica":
                    $ris_finale["plastica"][$mese-1]++; break;
                case "carta":
                    $ris_finale["carta"][$mese-1]++; break;
                case "raee":
                    $ris_finale["raee"][$mese-1]++; break;
            }
        }
}
echo json_encode($ris_finale);

?>
