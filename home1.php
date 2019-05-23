<?php
	include "db.php"; 
	session_start();
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
    <script src="https://www.chartjs.org/dist/2.8.0/Chart.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

	<title>Home</title>
	<style>
		header{
			width: 100%;
			height: 70px;
			padding-top: 20px;
			background-color: #2795a0;
		}
		footer{
			width: 100%;
			height: 200px;
			background-color: #2795a0;
		}
		body{
			background-color: #dbdbdb;
			user-select: none;
			overflow-x: hidden;
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
		.dispositivoinput{
		    padding-top: 0.1px;
		    padding-bottom: 0.1px;
		    text-align: left;
		    margin-left: 1px;
		    width: 99%;
		    border-left: 3px #1ddc0d solid;
		    transition: all 0.1s;
		    text-decoration: none;
		    height: 50px
		}

		.dispositivoinput p{
		    margin-left: 30px;
		    font-size: 14px;
		    color: black;
		    font-family: titillium web;
		}

		.dispositivoinput:hover{
		    border-left: 4px #2bcc1d solid;
		    background-color: #f0f0f0;
		    cursor: pointer;
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
		#filtra{
			width: 80px;
			padding: 2.5px;
			background-color: #f5f5f5;
			border-radius: 5px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.06), 0 6px 20px 0 rgba(0, 0, 0, 0.06);
			display: inline-block;
			transition: 0.2s;
			float: right;
			margin-right: 30px;
			border: 1px #e7e7e7 solid;
			margin-top: 2.5px;
		}
		#filtra:active{
			transform: translateY(2px);
			box-shadow: 0 3px 4px 0 rgba(0, 0, 0, 0.09), 0 5px 14px 0 rgba(0, 0, 0, 0.11)
		}
	</style>
</head>
<body>
	<header>
		<!-- LOGO -->
		<div style="width: 200px;height: 50px;margin-left: 100px;float: left;">
			<p style="font-size: 35px;font-family: lobster;margin: 0px;display: inline-block;"><a href="home1.php" style="color: white;text-decoration: none">Cassonetto</a></p>
		</div>

		<div style=" display: inline-block; float: right;margin-right: -100px">
			<?php if (isset($_SESSION['rfid'])) { ?>
				<form action="home1.php" method="POST">
					<button class="button" type="submit" name="Btn_Esci">Esci</button>
				</form>
				<?php
					if (isset($_POST['Btn_Esci'])) {
						session_destroy();
						header('Location: home1.php');
					}
				?>
			<?php }else{ ?>
				<form action="home1.php" method="POST">
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
								$results = mysqli_query($db,$queryverifica);
								$righe = mysqli_num_rows($results);
								if ($righe !=1) {
									$errori['dati'] = "Email e/o password non corretti";
								}else{
									$ricavareid = "SELECT rfid FROM utente WHERE email = '$email'";
									$risultatiid = mysqli_query($db,$ricavareid);
									while ($row1 = $risultatiid->fetch_assoc()) {
										$_SESSION['rfid'] = $row1['rfid'];
										$rfid = $_SESSION['rfid'];
									}
									header('Location: home1.php');
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


	<div style="width: 100%;margin-top: 60px;margin-bottom: 100px">
		<div style="margin: auto;width:1000px;height: 1000px;background-color: white;border-radius: 5px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.08), 0 6px 20px 0 rgba(0, 0, 0, 0.05)">
			<div style="width: 100%;background-color: #81d1d9;margin: auto;border-radius: 5px 5px 0px 0px;text-align: center;padding:10px 0px 10px 0px">
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
						<div style="width: 500px;margin: 5px 15px 0px 15px;display: inline-block;vertical-align: top;transform: scale(0.9);">
				<?php
							$queryprendidati="SELECT * FROM operazione WHERE rfid_utente='$rfid' order by giorno_e_ora desc";
							$risultati = mysqli_query($db,$queryprendidati);
							if (mysqli_num_rows($risultati)!=0) {?>
								<p style="font-family: oswald;font-weight: 600;margin-left: 40px;color: #444444">TIPO <span style="margin-left: 76px">PESO</span><span style="margin-left: 35px">PUNTI ACCUMULATI</span><span style="margin-left: 40px">DATA E ORA</span></p>

								<?php
									while ($rowdati = mysqli_fetch_array($risultati,MYSQL_ASSOC)) {
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
            		<div style="width: 445px;height: 35px;margin-left: -5px;margin-top: 35px;margin-bottom: -25px;border-bottom: 1.5px #e7e7e7 solid;padding-bottom: 4px">
	        			<select style="width: 180px;height: 30px;border-radius: 4px;outline: none;font-family: oswald;font-size: 14px;border: 1px solid #e3e3e3;background-color: #f3f3f3;color: #888888;display: inline-block;float: left;margin-bottom: -25px;margin-left: 30px">
							<option value="0">Seleziona un periodo</option>
						</select>
						<div style="outline: none;color: grey;font-family: titillium web;font-size: 13px;font-weight: 700;text-align: center;cursor: pointer;margin-bottom: -25px" id="filtra">
							Filtra
						</div>
            		</div>
            		<div id="chart" style="width: 600px;transform: scale(0.75);margin-left: -85px;color: #444444;">
	                    <canvas id="canvas"></canvas>
	                </div>
	                <?php
		                $querypunteggio = "SELECT sum(peso) as peso_totale,tipo_di_rifiuto FROM operazione WHERE rfid_utente = '$rfid' GROUP BY tipo_di_rifiuto";
		                $risultatipunteggio = mysqli_query($db,$querypunteggio);
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
	                
                <script>
                    var metallo, vetro, indifferenziato, umido, plastica, carta, raee;
                        
                    $.post( "chart1.php", '{ "anno": 2019 }')
                      .done(function(result){
                        console.log(result);
                        result = $.parseJSON(result);
                        metallo = result.metallo;
                        vetro = result.vetro;
                        indifferenziato = result.indifferenziato;
                        umido = result.umido;
                        plastica = result.plastica;
                        carta = result.carta;
                        raee = result.raee;

                    window.chartColors = {
	                    red: 'rgb(255, 99, 132)',
	                    orange: 'rgb(255, 159, 64)',
	                    yellow: 'rgb(255, 205, 86)',
	                    green: 'rgb(75, 192, 192)',
	                    blue: 'rgb(54, 162, 235)',
	                    purple: 'rgb(153, 102, 255)',
	                    grey: 'rgb(201, 203, 207)'
                    };
		            var barChartData = {
			            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
			            datasets: [{
				            label: 'metallo',
				            backgroundColor: window.chartColors.red,
				            data: metallo
			            }, {
				            label: 'vetro',
				            backgroundColor: window.chartColors.blue,
				            data: vetro
			            }, {
				            label: 'indifferenziato',
				            backgroundColor: window.chartColors.green,
				            data: indifferenziato
			            }, {
				            label: 'umido',
				            backgroundColor: window.chartColors.orange,
				            data: umido
			            }, {
				            label: 'plastica',
				            backgroundColor: window.chartColors.yellow,
				            data: plastica
			            }, {
				            label: 'carta',
				            backgroundColor: window.chartColors.purple,
				            data: carta
			            }, {
				            label: 'raee',
				            backgroundColor: window.chartColors.grey,
				            data: raee
			            }]

		            };

		            var ctx = document.getElementById('canvas').getContext('2d');
		            window.myBar = new Chart(ctx, {
			            type: 'bar',
			            data: barChartData,
			            options: {
				            title: {
					            display: true,
					            text: 'Operazioni effettuate '
				            },
				            tooltips: {
					            mode: 'index',
					            intersect: false
				            },
				            responsive: true,
				            scales: {
					            xAxes: [{
						            stacked: true,
					            }],
					            yAxes: [{
						            stacked: true
					            }]
				            }
			            }
		            });
                });
	        </script>
            <?php } ?>
		</div>
	</div>


	<footer>
	</footer>
</body>
</html>
