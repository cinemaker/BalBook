<html>
	<head>
		<title>Startseite</title>
		<meta charset="utf-8"> 
		<link rel="stylesheet" type="text/css" href="LoginScreen.css">

	</head>
	<body>
		
		<div class="Kopfzeile">
			<h1> StudiK2 </h1>

			<!--links zu startseite-->
			<!-- Suche -->
			<form class="Kopfzeile" action="Homepage.php" accept-charset="utf-8" method="GET">
				SUCHE: 
				<input type="text" name="email" value="">
				<input type="submit" name="suchen">

			</form>
		</div>

		<div class="Login">
			
			<h3>Login:</h3>
			
			<form action="Loginscreen.php" accept-charset="utf-8" method="POST">
			  Email:
			  <br>
			  <input type="text" name="email" value="">
			  <br>
			  Passwort:
			  <br>
			  <input type="password" name="passwort" value="">
			  <br>
			  <br>
			  <input type="hidden" name="LoginGesendet" value="1">
			  <input type="submit" value="Anmelden">
			</form>

		<?php 
			if (isset($_POST['LoginGesendet'])) {

			//URL Argumente
				$email = $_POST["email"];
				$passwort = $_POST["passwort"];

			//Query
				$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
				$pdo->query("SET NAMES 'utf8'");
				
				$sql = "SELECT passwort,nummer FROM balbook WHERE email = '". $email . "'";

				foreach ($pdo->query($sql) as $row) {
				   if ($row['passwort'] == $passwort) {
					   //Passwort stimmt, User wird angemeldet
					    $angemeldet = "UPDATE balbook SET angemeldet = 1 WHERE email = '". $email . "'";
					    $pdo->query($angemeldet);
					 
					   //LOG
						file_put_contents("log.txt",$email." hat sich um ".date("G:i:s")." angemeldet am ".date("d. M y")."\n" , FILE_APPEND);
						
						//ID
						 $id = $pdo->query("SELECT nummer FROM balbook WHERE email = '". $email . "'");
						 foreach ($id as $row) {
							$id = $row[0];
						}
						
						
						//Session Variablen
						session_id($id);
						session_start();
						$_SESSION["email"] = $email;
						$_SESSION["passwort"] = $passwort;
						$_SESSION["nachrichtenanzahl"] = 20;
						session_write_close();
					    header("Location: Homepage.php?id=".$id); 
					   
				   } else {
					   //Passwort stimmt nicht
					   echo "Passwort stimmt nicht!";
				   }
				}
				
			}
		?>
		</div>

		<div class='Registrieren' >
			
			<h3>Registrieren:</h3>
			<form action="Loginscreen.php" accept-charset="utf-8" method="POST">
				<br>
				Vorname:
				<input type="text" name="vorname"  class='Registrieren'>
				<br><br>
				Nachname:
				<input type="text" name="nachname"  class='Registrieren'>
				<br><br>
				Email:
				<input type="text" name="email"  class='Registrieren'>
				<br><br>
				Passwort:
				<input type="password" name="passwort"  class='Registrieren'>
				<br><br>
				Passwort wiederholen:
				<input type="password" name="passwort2"  class='Registrieren'>
				<br><br>
				Wohnort: 
				<input type="text" name="wohnort"  class='Registrieren'>
				<br><br>
				Postleitzahl:
				<input type="number" name="plz"  class='Registrieren'>
				<br><br>
				Geburtstag:       
				<input type="date" name="date"   class='Registrieren'>
			  	<input type="hidden" name="RegistrierenGesendet" value="1">
			  <br><br>
			  <input type="submit" value="Registrieren">
			  
			  
			  
			</form>
			<?php 
				if (isset($_POST['RegistrierenGesendet'])) {
					$email = $_POST["email"];
					$vorname = $_POST["vorname"];
					$nachname = $_POST["nachname"];
					$passwort = $_POST["passwort"];
					$passwort2 = $_POST["passwort2"];
					$wohnort = $_POST["wohnort"];
					$plz = $_POST["plz"];
					$date = $_POST["date"];
			
			
			//Prüfen ob alle Daten vorhanden sind
			$allThere = false;
			if ($email && $vorname && $nachname && $passwort && $passwort2 && $wohnort && $plz && $date) {
				$allThere = true;
			}
			
			//Tests vor dem Registrieren
			$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
			if ($allThere == true) {
			if ($passwort == $passwort2) {
				$bool = false;
				$datum = explode("-", $date);
				$heute = date("m.d.y"); 
				$heute = explode(".", $heute);
				if ($datum[0]-$heute[2]-2000 <= 0) {
					$sql = "SELECT * FROM balbook WHERE email = '".$email."'";
					foreach ($pdo->query($sql) as $row) {
					   echo "YEAH";
					   $bool = true;
					}
					if ($bool == false) {
						
						
						//CHECKEN OB ADRESSE & PLZ ÜBEREINSTIMMER
						$WohnortDa = false;
						$sql = "SELECT Wohnort FROM wohnorte WHERE PLZ = ".$plz;
						foreach ($pdo->query($sql) as $row) {
							//Der Wohnort is schon in der Liste
							$WohnortDa = true;
						}
						if ($WohnortDa == false) {
							$sql = "INSERT INTO `wohnorte` (`PLZ`,`Wohnort`) VALUES (".$plz.",'".$wohnort."')";
							$pdo->query($sql);
						}
						
						//Die Daten können eingefügt werden
						//Die Nummer herausfinden
						$sql = $pdo->query('SELECT MAX(`Nummer`) FROM balbook');
						foreach ($sql as $row) {
							$nummer = $row[0];
						}
						//einfügen
						$sql = "INSERT INTO `balbook`( `Vorname`, `Nachname`, `Email`, `Passwort`, `PLZ`, `Birthday`, `Nummer`, `Angemeldet`) VALUES ('".$vorname."','".$nachname."','".$email."','".$passwort."','".$plz."','".$date."','".($nummer+1)."',true)";
						$pdo->query($sql);
						
						
						//LOG
						file_put_contents("log.txt",$email." hat sich um ".date("G:i:s")." am ".date("d. M y")." registriert"."\n" , FILE_APPEND);
						

						session_id($nummer+1);
						session_start();
						$_SESSION["email"] = $email;
						$_SESSION["passwort"] = $passwort;
						session_write_close();
						header("Location: ../Homepage.php?id=".($nummer+1)); 
						
					} else {
						//Die Email wird breits verwendet
						echo '<h1 style=\'margin-left: 5%\'>Diese Email wird bereits verwendet</h1>';
						$bool = true;
					}
					
				} else {
					// Das Datum liegt in der Zukunft
					echo '<h1 style=\'margin-left: 5%\'>Das Datum liegt in der Zukunft</h1>';
					$bool = true;
				}
						
			} else {
				// Passwörter sind falsch
				echo '<h1 style=\'margin-left: 5%\'>Die Passwörter stimmen nicht überein</h1>';
				$bool = true;
			}
			} else {
				//Es fehlen Daten
				echo '<h1 style=\'margin-left: 5%\'>Es fehlen Daten</h1>';
				$bool = true;
			}


				}
			?>
		</div>
		<div class="UntereLeiste">
			<center>Copyright 2017</center>
			<center>Ein Projekt des Informatikkurs am Gymnasium Balingen</center>
			<center>Pascal Müller , Philipp Schanz</center>
			
			<center>StudiK2 © 2017</center>
			<center>Herr Schäfer übernimmt volle Haftung</center>
		</div>

	</body>
</html>