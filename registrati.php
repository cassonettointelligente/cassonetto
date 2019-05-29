<?php
	include "db.php"; 
	session_start();
	ob_start();
?>
<!DOCTYPE HTML PUBLIC="-//W3C//DTD HTML 4.0//EN">
<HTML>
<HEAD>
<META name="keywords" >
<meta charset="UTF-8">
<META name= "author" Content = "Simone Villanova">
<meta name="GENERATOR" content="Notepad++ di Windows 10">
<link rel="shortcut icon" type="image/x-icon" href="icon.png">
<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Staatliches" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Titillium+Web:300" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
<TITLE>Online-Shop</TITLE>
<style>
	html,body{
		overflow-x: hidden;
		cursor: url(cursore.png), default;

	}
	header{
		width: 100%;
		height: 70px;
		padding-top: 20px;
		background-color: #2795a0;
	}
	/* width */
	::-webkit-scrollbar {
		width: 8px;
	}
	/* Track */
	::-webkit-scrollbar-track {
		background: #f1f1f1; 
	}
	/* Handle */
	::-webkit-scrollbar-thumb {
		background: #888; 
	}
	/* Handle on hover */
	::-webkit-scrollbar-thumb:hover {
		background: #555; 
	}
	.inserimentodatidiregistrazione{
		padding: 7px 10px;
		font-size: 14px;
		border: none;
		background-color: #eaeaea;
		width: 270px;
		outline: none;
		border-radius: 3px
	}
	#bottoneregistrati{
		border: none;
		margin-left: 20px
		outline: none;
		width: 80px;
		transition: all 0.1s;
		border-radius: 11px;
		padding: 3px;
		padding-top: 5px;
		padding-bottom: 5px
	}
	#bottoneregistrati:hover{
		background-color: #c7c7c7;
	}
	#bottoneregistrati:active{
		transform: translateY(2px);
	}
	p{
		font-family: arial
	}
	.button {
		outline: none;
		float: right;
		padding: 6px 10px;
		margin-right: 150px;
		margin-top: 10px;
		background-color: #00b999;
		color: #f0f0f0;
		font-size: 16px;
		border: none;
		cursor: pointer;
		border-radius: 3px;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.08), 0 6px 20px 0 rgba(0, 0, 0, 0.05);
		transition: all 0.2s
	}
	.button:active{
		transform: translateY(2px);
		box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.09), 0 3px 10px 0 rgba(0, 0, 0, 0.06);
	}
	.button:hover {
		background-color: #00a88b;
	}
	.inserimentodatidiaccesso{
		padding: 7px 10px;
		margin-top: 10px;
		font-size: 14px;
		border: none;
		float: right;
		margin-right: 5px;
		width: 160px;
		outline: none
	}
</style>
<head>
</head>
<body style="background-color: lightgrey">
	<header>
		<!-- LOGO -->
		<div style="width: 200px;height: 50px;margin-left: 100px;float: left;">
			<p style="font-size: 35px;font-family: lobster;margin: 0px;display: inline-block;"><a href="home.php" style="color: white;text-decoration: none">Cassonetto</a></p>
		</div>

		<div style=" display: inline-block; float: right;margin-right: -100px">
			<a href="home.php" style="text-decoration: none"><button class="button" type="submit" name="Btn_Esci">Accedi</button></a>
		</div>
	</header>
	<div style="width: 100%;">
		<div style="width: 800px;background-color: white;margin: auto;margin-top: 60px;border-radius: 5px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1), 0 6px 20px 0 rgba(0, 0, 0, 0.05);margin-bottom: 100px">
			<div style="width: 100%;border-top-right-radius: 3px;border-top-left-radius: 3px;background-color: #81d1d9;padding-top: 13px;padding-bottom: 13px">
				<p style="text-align: center;font-size: 25px;margin: 0px;color: white;font-family: staatliches;">Registrazione</p>
			</div>
			<?php
			$errori = array();
				if (isset($_GET['rfid'])) {
					$rfid = $_GET['rfid'];
					if (empty($rfid)) {
						$errori['dati'] = "Campo rfid non valido.";
					}else{
						$rfid = str_replace(' ', '', $rfid);
						if (strlen($rfid)!= 8 ) {
							$errori['dati'] = "Lunghezza rfid non valida.";
						}else{
							$queryverificadisonibilita = "SELECT * FROM utente WHERE rfid = '$rfid'";
							$risultativerifica = mysqli_query($sqlconn,$queryverificadisonibilita);
							if (mysqli_num_rows($risultativerifica) == 0) {
								if (isset($_POST['btn'])) {
									$nome = $_POST['nome'];
									$cognome = $_POST['cognome'];
									$email = $_POST['email'];
									$password = $_POST['pswd'];
									$confpassword = $_POST['confpswd'];
									$citta = $_POST['citta'];
									$provincia = $_POST['provincia'];
									$indirizzo = $_POST['indirizzo'];
									$cap = $_POST['cap'];
									$codfis = $_POST['codfis'];

									if (isset($_SESSION['rfid'])) {
										$errori['dati'] = "Prima di registrare un nuovo profilo devi uscire da quello attuale";
									}else{
										if (empty($nome) or empty($cognome) or empty($email) or empty($password) or empty($confpassword) or empty($citta) or empty($provincia) or empty($indirizzo) or empty($codfis) or empty($cap)) {
											$errori['dati'] = "Mancano i dati richiesti o non sono corretti.";
										}else{
											if (isset($_POST['sesso']) and isset($_POST['datadinascita']) and $password==$confpassword and strlen($codfis)==16) {
												$sesso = $_POST['sesso'];
												$datadinascita = $_POST['datadinascita'];
												$emailquery = "SELECT * FROM utente WHERE email = '$email'";
												$results = mysqli_query($sqlconn,$emailquery);
												$righe = mysqli_num_rows($results);
												if ($righe != 0) {
													$errori['email'] = "Email già registrata";
												}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
													$errori['email'] = "Formato email non valido";
												}
												$viaenumerocivico2 = $indirizzo;
												$cap2 = $cap;
												$citta2 = $citta;
												$provincia2 = $provincia;

												$indirizzo1 = str_replace(" ", "+",($viaenumerocivico2. " " . $cap2 . " " . $citta2 . " " . $provincia2));
												$url = "https://api.tomtom.com/search/2/geocode/".$indirizzo1.".json?key=8kwORCGm23TYNfdlMrzLkn4cM2oluaSp";
												$response = file_get_contents($url);
												$array = json_decode($response,true);

												$via = "";
												for ($i=0; $i < sizeof(explode(' ', $viaenumerocivico2))-1; $i++) { 
													$via = $via . explode(' ', $viaenumerocivico2)[$i]. " ";
												}
												$via2 = substr($via, 0,strlen($via)-1);
												$via2 = strtolower($via2);
												$citta2 = strtolower($citta2);
												$provincia2 = strtolower($provincia2);

												$via = strtolower($array["results"][0]["address"]["streetName"]);
												$citta = strtolower($array["results"][0]["address"]["municipality"]);
												$provincia = strtolower($array["results"][0]["address"]["countrySecondarySubdivision"]);
												$cap = strtolower($array["results"][0]["address"]["postalCode"]);


												if ($via2 != $via or $cap2 != $cap or $citta2 != $citta or $provincia2 != $provincia) {
													$errori['indirizzo'] = "Il tuo indirizzo non esiste.";
												}

											}else{
												$errori['dati'] = "Mancano i dati richiesti o non sono corretti.";
											}
										}
									}
								}else{
									$errori['dati'] = "Clicca il pulsante registrati per registrarti.";
								}
							}else{
								$errori['dati'] = "Questo rfid è già stato registrato.";
							}
						}
					}
				}else{
					$errori['dati'] = "Inserisci un campo rfid.";
				}
					
				if (count($errori) == 0) {
					$password = md5($password);

					$sql = "INSERT INTO utente(rfid,nome,cognome,email,psswd,sesso,data_di_nascita,codice_fiscale,citta,provincia,cap,via_e_numero_civico) VALUES ('$rfid','$nome','$cognome','$email','$password','$sesso','$datadinascita','$codfis','$citta','$provincia','$cap','$indirizzo')";
					if (mysqli_query($sqlconn, $sql)) {			
						$_SESSION['rfid'] = $rfid;
						header('Location: home.php');
					}
				}else{
					echo '<div style="background-color: lightgrey;margin-left: 100px;margin-top: 30px;padding: 4px 20px 4px 20px;border-radius: 3px;color: black;width: 547px;margin-bottom:-10px">';
						foreach ($errori as $errore) {
							echo '<p style="margin: 0px;font-family: titillium web;font-size: 13px;font-weight: 600">'. $errore .'</p>';
						}
					echo '</div>';
				}
			?>
			<div style="padding-top: 40px;padding-bottom: 40px">
				<?php
					if (isset($_GET['rfid'])) {
						echo '<form action="registrati.php?rfid='.$_GET['rfid'].'" method="POST">';
					}else{
						echo '<form action="registrati.php" method="POST">';
					}
				?>
				
					<div id="Utente" style="display: inline-block; vertical-align: top;">
						<table style="margin-right: 20px;margin-left: 105px">
							<tr>
								<td>
									<table>
										<tr>
											<td style="width: 130px;margin-left: -2px;height: 12px">
												<p style="font-size: 14px;margin-left: -2px;">Nome</p>
											</td>
											<td style="width: 130px;margin-left: -2px;height: 12px">
												<p style="font-size: 14px;margin-left: 3px">Cognome</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table>
										<tr>
											<td>
												<input  type="text" class="inserimentodatidiregistrazione" style="width: 130px;margin-left: -2px;" name="nome" value="<?php if(isset($_POST['nome'])){echo $_POST['nome'];} ?>">
											</td>
											<td>
												<input  type="text" class="inserimentodatidiregistrazione" style="width: 130px;margin-left: 5px" name="cognome" value="<?php if(isset($_POST['cognome'])){echo $_POST['cognome'];} ?>">
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr style="height: 10px"></tr>
							<tr>
								<td>
									<p style="font-size: 14px;">E-Mail</p>
								</td>
							</tr>
							<tr>
								<td>
									<input  type="text" class="inserimentodatidiregistrazione" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
								</td>
							</tr>
							<tr style="height: 10px"></tr>
							<tr>
								<td>
									<p style="font-size: 14px;">Password</p>
								</td>
							</tr>
							<tr>
								<td>
									<input  type="password" class="inserimentodatidiregistrazione" name="pswd">
								</td>
							</tr>
							<tr style="height: 10px"></tr>
							<tr>
								<td>
									<p style="font-size: 14px;">Conferma Password</p>
								</td>
							</tr>
							<tr>
								<td>
									<input  type="password" class="inserimentodatidiregistrazione" name="confpswd">
								</td>
							</tr>
							<tr style="height: 10px"></tr>
							<tr>
								<td>
									<table>
										<tr>
											<td width="130px">
												<p style="font-size: 14px; margin-left: -3px">Sesso</p>
											</td>
											<td>
												<p style="font-size: 14px;margin-left: -1px">Data di nascita</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table>
										<tr>
											<td width="130px">
												<p style="display: inline-block; margin-top: 10px">M</p><input  type="radio" name="sesso" value="M" <?php if ( isset($_POST['sesso']) and $_POST['sesso'] == 'M') { ?>
													checked="true"
												<?php
												} ?> >
												<p style="display: inline-block; margin-top: 0px">&nbsp&nbsp&nbsp&nbsp&nbspF</p><input  type="radio" name="sesso" value="F" <?php if (isset($_POST['sesso']) and  $_POST['sesso'] == 'F') { ?>
													checked="true"
												<?php
												} ?> >
											</td>
											<td>
												<input type="date" style="margin-top: -7px; width: 135px; background-color: #eaeaea;outline: none;border: none;height: 30px;border-radius: 3px;padding-left: 10px;margin-left: -1px" name="datadinascita" value="<?php if(isset($_POST['datadinascita'])){echo $_POST['datadinascita'];} ?>" >
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
					<div id="Azienda" style="display: inline-block; vertical-align: top">
						<table>
							<tr style="height: 1px"></tr>
							<tr>
								<td>
									<p style="font-size: 14px; margin-left: -2px">Codice fiscale</p>
								</td>
							</tr>
							<tr style="height: 3px"></tr>
							<tr>
								<td>
									<input  type="text" class="inserimentodatidiregistrazione" style="margin-left: -2px" name="codfis" value="<?php if(isset($_POST['codfis'])){echo $_POST['codfis'];} ?>">
								</td>
							</tr>
							<tr style="height: 10px"></tr>
							<tr>
								<td>
									<table>
										<tr>
											<td>
												<p style="font-size: 14px; margin-left: -5px;margin-bottom: -12px">Citta</p>
											</td>
											<td>
												<p style="font-size: 14px; margin-left: 147px;margin-bottom: -12px">Provincia</p>
											</td>
										</tr>
										<tr style="height: 5px"></tr>
									</table>
								</td>
							</tr>
							<tr>
								<table>
									<tr>
										<td>
											<input  type="text" class="inserimentodatidiregistrazione" style="width: 160px;margin-left: -2px" name="citta" value="<?php if(isset($_POST['citta'])){echo $_POST['citta'];} ?>">
										</td>
										<td>
											<input  type="text" class="inserimentodatidiregistrazione" style="width: 90px; margin-left: 15px " name="provincia" value="<?php if(isset($_POST['provincia'])){echo $_POST['provincia'];} ?>">
										</td>
									</tr>
									<tr style="height: 2px"></tr>
								</table>
							</tr>
							<tr>
								<td>
									<table>
										<tr>
											<td>
												<p style="font-size: 14px; margin-left: -2px;margin-top: 7px;margin-bottom: -2px">Indirizzo</p>
											</td>
											<td>
												<p style="font-size: 14px; margin-left: 123px;margin-top: 7px;margin-bottom: -2px">Cap</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							
							<tr>
								<table>
									<tr>
										<td>
											<input  type="text" class="inserimentodatidiregistrazione" style="width: 160px;margin-left: -2px" name="indirizzo" value="<?php if(isset($_POST['indirizzo'])){echo $_POST['indirizzo'];} ?>">
										</td>
										<td>
											<input  type="text" class="inserimentodatidiregistrazione" style="width: 90px; margin-left: 15px " name="cap" value="<?php if(isset($_POST['cap'])){echo $_POST['cap'];} ?>">
										</td>
									</tr>
								</table>
							</tr>
						</table>
					</div>
					<table style="margin: auto;margin-top: 20px">
						<tr>
							<td>
								<input type="submit" id="bottoneregistrati" style="outline: none;cursor: pointer;margin-bottom: 20px" name="btn" value="Registrati">
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
