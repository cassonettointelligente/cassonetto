<?php
	include "db.php"; 
	session_start();
	ob_start();
	if (isset($_SESSION['rfid'])) {
		$rfid = $_SESSION['rfid'];
	}
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Staatliches" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Titillium+Web:300" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style.css">
    <script src="https://www.chartjs.org/dist/2.8.0/Chart.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">

	<title>Home</title>
</head>
<body>
	<header>
		<!-- LOGO -->
		<div style="width: 200px;height: 50px;margin-left: 100px;float: left;">
			<p style="font-size: 35px;font-family: lobster;margin: 0px;display: inline-block;"><a href="home.php" style="color: white;text-decoration: none">Cassonetto</a></p>
		</div>

		<div style=" display: inline-block; float: right;margin-right: -100px">
			<?php if (isset($_SESSION['rfid'])) { ?>
				<form action="home.php" method="POST">
					<button class="button" type="submit" name="Btn_Esci">Esci</button>
				</form>
				<?php
					if (isset($_POST['Btn_Esci'])) {
						session_destroy();
						header('Location: home.php');
					}
				?>
			<?php }else{ ?>
				<form action="home.php" method="POST">
					<button class="button" type="submit" name="Btn_Accedi">Login</button>
					<input class="inserimentodatidiaccesso" style="margin-right: 15px" type="password" placeholder="Password" name="pswd">
					<input class="inserimentodatidiaccesso" type="text" placeholder="E-Mail" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
				</form>	
				<br>
				<?php
					if (isset($_POST['Btn_Accedi'])) {
						$errori = array();
						$email = $_POST['email'];
						$password = $_POST['pswd'];
						if (empty($email) or empty($password)) {
							$errori['dati'] = "Inserisci entrambi i dati"; 
						}else{
							if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
								$errori['dati'] = "Formato email non valido";
							}else{
								$password = md5($password);
								$queryverifica = "SELECT * FROM utente WHERE email = '$email' and psswd = '$password'";
								$results = mysqli_query($sqlconn,$queryverifica);
								$righe = mysqli_num_rows($results);
								if ($righe !=1) {
									$errori['dati'] = "Email e/o password non corretti";
								}else{
									$ricavareid = "SELECT rfid FROM utente WHERE email = '$email'";
									$risultatiid = mysqli_query($sqlconn,$ricavareid);
									while ($row1 = $risultatiid->fetch_assoc()) {
										$_SESSION['rfid'] = $row1['rfid'];
										$rfid = $_SESSION['rfid'];
									}
									header('Location: home.php');
								}
							}
						}
					}
					if (isset($errori['dati'])) {
						echo '<div style="padding: 2px 10px 2px 10px;margin-bottom: 0px;background-color: lightgrey;border-radius: 3px;float: left;margin-top: 5px">
						<p style="margin: 0px;color: black;font-size: 11px;font-family: titillium web;font-weight: 600">' . $errori['dati']. '</p></div>';
					} ?>
				
				<div style="font-size: 11px; color: lightgrey;margin-top: 10px;font-family: arial;float: right;margin-right: 160px">non sei registrato? <span><a href="registrati.php" style="text-decoration: none;color: white">Registrati!</a> </span>
				</div>
			<?php } ?>
		</div>
	</header>
	<div style="width: 100%;text-align: center;user-select: none">
		<div style="width: 950px;margin: auto;margin-top: 50px">
			<?php
				if (isset($_POST['ricerca'])) {
					$ricerca = $_POST['ricerca'];
					$queryprezzomassimo = "SELECT max(prezzo) as prezzo FROM articolo, tipologia_articolo WHERE articolo.id_articolo = tipologia_articolo.id_articolo";
					$risultatiprezzo = mysqli_query($sqlconn,$queryprezzomassimo);
					while ($row1 = mysqli_fetch_array($risultatiprezzo)) {
						$prezzomassimo = intval($row1['prezzo'])+1;
					}
					$url = "Location: ricercaarticoli.php?ricerca=$ricerca&btn_src=&aprezzo=$prezzomassimo&select_categoria=0";
					header($url);
				}
			?>
			<div id="icone">
				<?php 
					# Filtro per chi non ha i permessi
					if (isset($_SESSION['rfid'])) {
						$c = $_SESSION['rfid'];
						
				?>
				<div style="height: 15px;width: 15px;border-radius: 8px;background-color: red;margin-right: -10px;margin-top: -34px;float: right;">
					<p style="color: white;font-size: 10px;margin-top:2px"></p>
				</div>
				<div style="float: right;margin-top: -34px;">
					<div style="width: 35px;height: 35px;background-color: #050505;border-radius: 50%;margin-top: 1.5px">
						<img src="campanella.png" style="width: 25px">
					</div>
				</div>
				<div style="float: right;margin-top: -34px;margin-right: 10px" onclick="Account('tendinaaccount')">
					<img src="account.png" style="width: 36px;cursor: pointer;">
				</div>
				<div id="tendinaaccount">
					<div class="speech-bubble">
						<div style="width: 100%;border-bottom: thin lightgrey solid;border-top: thin solid #f0f0f0;margin-top: 35px">
							<a href="inserimentodatiutente.php" style="text-decoration: none"><p style="margin-bottom: 5px;margin-top: 5px;color: #909092;font-size: 13px">Modifica Account</p></a>
						</div>
						<div style="width: 100%;border-bottom: thin lightgrey solid;">
							<a href="storicoordini.php" style="text-decoration: none"><p style="margin-bottom: 5px;margin-top: 5px;color: #909092;font-size: 13px">Ordini Eseguiti</p></a>
						</div>
						<br>
					</div>
				</div>

				<?php
						$c = $_SESSION['rfid'];
						$query = "SELECT * FROM utente WHERE rfid = '$c'";
						$verificadipendente = mysqli_query($sqlconn,$query);
						while ($row = mysqli_fetch_array($verificadipendente)) {
							if ($row['cliente_dipendente'] == 1 or $row['cliente_dipendente'] == 2) {
				?>

				<div onclick="Impostazioni('tendina')">
					<div style="float: right;margin-top: -34px;margin-right: 10px;" onclick="RotazioneImpostazioni(this)">
						<img src="impostazioni.png" class="bar1" style="width: 36px;cursor: pointer;">
					</div>
				</div>
				<div id="tendina">
					<div class="speech-bubble">
						<div style="width: 100%;border-bottom: thin lightgrey solid;border-top: thin solid #f0f0f0;margin-top: 35px;border-bottom-left-radius: 3px;border-bottom-right-radius: 3px">
							<a href="manutenzione.php" style="text-decoration: none"><p style="margin-bottom: 5px;margin-top: 5px;color: #909092;font-size: 13px">Manutenzione</p></a>
						</div>
					</div>
				</div>

				<?php
							}
						}
					}
				?>
			</div>
				




		</div>
	</div>

	<div style="width: 100%;margin-top: 70px;margin-bottom: 100px">
		<div id="contenitoregenerale">
			<div id="titolohome">
				<?php
					if (isset($rfid)) {
						echo '<p style="font-family: staatliches;color: white;font-size: 25px;margin: 0px;">STORICO OPERAZIONI</p>';
					}else{
						echo '<p style="font-family: staatliches;color: white;font-size: 25px;margin: 0px;">HOME</p>';
					}
				?>
				
			</div>
			
				<?php
					if (isset($rfid)) {?>
						<div style="width: 500px;margin: 5px 15px 0px 5px;display: inline-block;vertical-align: top;transform: scale(0.9);">
				<?php
							$queryprendidati="SELECT * FROM operazione WHERE rfid_utente='$rfid' order by giorno_e_ora desc";
							$risultati = mysqli_query($sqlconn,$queryprendidati);
							if (mysqli_num_rows($risultati)!=0) {?>
								<p style="font-family: oswald;font-weight: 600;margin-left: 40px;color: #444444">TIPO <span style="margin-left: 76px">PESO</span><span style="margin-left: 35px">PUNTI ACCUMULATI</span><span style="margin-left: 40px">DATA E ORA</span></p>

								<?php
									while ($rowdati = mysqli_fetch_array($risultati)) {
										$tipo = $rowdati['tipo_di_rifiuto'];
										$peso = $rowdati['peso']." KG";
										$dataeora = $rowdati['giorno_e_ora'];
										if ($rowdati['tipo_di_rifiuto'] == "plastica") {
					                		$punteggio = $rowdati['peso'] * 6;
					                	}elseif ($rowdati['tipo_di_rifiuto'] == "metallo") {
					                		$punteggio = $rowdati['peso'] * 7;
					                	}elseif ($rowdati['tipo_di_rifiuto'] == "indifferenziato") {
					                		$punteggio = $rowdati['peso'] * 5;
					                	}elseif ($rowdati['tipo_di_rifiuto'] == "umido") {
					                		$punteggio = $rowdati['peso'] * 7;
					                	}elseif ($rowdati['tipo_di_rifiuto'] == "vetro") {
					                		$punteggio = $rowdati['peso'] * 6;
					                	}elseif ($rowdati['tipo_di_rifiuto'] == "carta") {
					                		$punteggio = $rowdati['peso'] * 5;
					                	}elseif ($rowdati['tipo_di_rifiuto'] == "raee") {
					                		$punteggio = $rowdati['peso'] * 3;
					                	}
										?>
								<div style="border-bottom: thin lightgrey solid; width: 94%; margin-top: 1px;margin-left: 17px;margin-bottom: 1px">
								</div>
								<div class="dispositivoinput">
									<p style="position: absolute;"><?php echo $tipo; ?></p>
									<p style="position: absolute;margin-left: 140px"><?php echo $peso; ?></p>
									<p style="position: absolute;margin-left: 250px"><?php echo $punteggio; ?></p>
									<p style="position: absolute;margin-left: 340px"><?php echo $dataeora; ?></p>
								</div>		
								<?php
									}
								?>
								<div style="border-bottom: thin lightgrey solid; width: 94%; margin-top: 1px;margin-left: 17px;margin-bottom: 1px">
								</div>
						<?php
							}else{
						?>
						<div style="background-color: lightgrey;margin-top: 30px;padding: 4px 20px 4px 20px;border-radius: 3px;color: #444444;width: 460px;margin-top: 30px">
						<p style="margin: 0px;font-family: titillium web;font-size: 13px;font-weight: 600">Non sono state effettuate operazioni</p>
						</div>
						<?php
							}
						?>
					</div>	
				<?php
					}
				?>
			

            <?php if (isset($rfid)) {?>
            	<div style="width: 445px;display: inline-block;vertical-align: top;float: right;position: absolute;">
            		<div style="width: 445px;height: 35px;margin-left: -5px;margin-top: 40px;margin-bottom: -25px;border-bottom: thin lightgrey solid;padding-bottom: 4px">
	        			<select style="width: 180px;height: 30px;border-radius: 4px;outline: none;font-family: oswald;font-size: 14px;border: 1px solid #e3e3e3;background-color: #f3f3f3;color: #888888;display: inline-block;float: left;margin-bottom: -25px;margin-left: 30px" id="datepicker">
						</select>
						<div style="outline: none;color: grey;font-family: titillium web;font-size: 13px;font-weight: 700;text-align: center;cursor: pointer;margin-bottom: -25px" id="filtra" onclick="btn()">
							Filtra
						</div>
            		</div>
            		<div id="chart" style="transform: scale(0.75);margin-left: -85px;color: #444444;">
	                    <canvas id="canvas" style="width: 600px;height: 400px"></canvas>
	                </div>
	                <?php
		                $querypunteggio = "SELECT sum(peso) as peso_totale,tipo_di_rifiuto FROM operazione WHERE rfid_utente = '$rfid' GROUP BY tipo_di_rifiuto";
		                $risultatipunteggio = mysqli_query($sqlconn,$querypunteggio);
		                $punteggioattuale =0;
		                while ($rowpunteggio = $risultatipunteggio->fetch_assoc()) {
		                	if ($rowpunteggio['tipo_di_rifiuto'] == "plastica") {
		                		$punteggioattuale = $punteggioattuale + $rowpunteggio['peso_totale'] * 6;
		                	}elseif ($rowpunteggio['tipo_di_rifiuto'] == "metallo") {
		                		$punteggioattuale = $punteggioattuale + $rowpunteggio['peso_totale'] * 7;
		                	}elseif ($rowpunteggio['tipo_di_rifiuto'] == "indifferenziato") {
		                		$punteggioattuale = $punteggioattuale + $rowpunteggio['peso_totale'] * 5;
		                	}elseif ($rowpunteggio['tipo_di_rifiuto'] == "umido") {
		                		$punteggioattuale = $punteggioattuale + $rowpunteggio['peso_totale'] * 7;
		                	}elseif ($rowpunteggio['tipo_di_rifiuto'] == "vetro") {
		                		$punteggioattuale = $punteggioattuale + $rowpunteggio['peso_totale'] * 6;
		                	}elseif ($rowpunteggio['tipo_di_rifiuto'] == "carta") {
		                		$punteggioattuale = $punteggioattuale + $rowpunteggio['peso_totale'] * 5;
		                	}elseif ($rowpunteggio['tipo_di_rifiuto'] == "raee") {
		                		$punteggioattuale = $punteggioattuale + $rowpunteggio['peso_totale'] * 3;
		                	}
		                }
		                $punteggioattuale = number_format((float)$punteggioattuale, 2, '.', '');
	                ?>
	                <p style="font-family: oswald;font-size: 15px;margin:0px;margin-top: -30px;font-weight: 700;color: #444444">Saldo attuale: <?php echo $punteggioattuale." punti"; ?></p>
            	</div>
	            <script src="code.js"></script>
            <?php } ?>
		</div>
	</div>
	<script>
		function RotazioneImpostazioni(x) {
			x.classList.toggle("change");
		}
		function Account(x){
			var panel = document.getElementById(x);
			if(panel.style.height == "67px"){
				panel.style.height = "0px";
			}else{
				panel.style.height = "67px";
			}
		}
		function Impostazioni(x){
			var panel = document.getElementById(x);
			if(panel.style.height == "41px"){
				panel.style.height = "0px";
			}else{
				panel.style.height = "41px";
			}
		}
	</script>
</body>
</html>
