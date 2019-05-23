<?php
session_start();
$json = file_get_contents('php://input');
$values = json_decode($json, true);

$rfid = $_SESSION['rfid'];

$anno = 2019;
$mese = 04;

$ris_finale = array("metallo" => array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0),
                    "vetro" => array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0),
                    "indifferenziato" => array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0),
                    "umido" => array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0),
                    "plastica" => array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0),
                    "carta" => array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0),
                    "raee" => array(0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0)
                    );

$sqlconn = mysqli_connect("localhost", "pi", "superuserboom", "cassonetto");

for($day = 1; $day<31; $day++){

        $query = "select tipo_di_rifiuto from operazione where extract(day from giorno_e_ora) = $day and extract(month from giorno_e_ora) = $mese and extract(year from giorno_e_ora) = $anno and rfid_utente = '$rfid';";

        $res = mysqli_query($sqlconn, $query);

        while ($row = $res->fetch_assoc()) {
            switch($row["tipo_di_rifiuto"]) {
                case "metallo":
                    $ris_finale["metallo"][$day-1]++; break;
                case "vetro":
                    $ris_finale["vetro"][$day-1]++;  break;
                case "indifferenziato":
                    $ris_finale["indifferenziato"][$day-1]++; break;
                case "umido":
                    $ris_finale["umido"][$day-1]++; break;
                case "plastica":
                    $ris_finale["plastica"][$day-1]++; break;
                case "carta":
                    $ris_finale["carta"][$day-1]++; break;
                case "raee":
                    $ris_finale["raee"][$day-1]++; break;
            }
        }
}
echo json_encode($ris_finale);

?>
