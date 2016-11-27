<html>
	<head>
		<title>Profil</title>
		<meta charset="utf-8"> 
		<link rel="stylesheet" href="stylesheet/LoginScreen.css">
		<link rel="stylesheet" href="stylesheet/SurroundStyle.css">
	</head>
	<body>
		
		

		
		<div class='title'>			
			<div class='LangLebeDasKomIntern'>			
				<img src="Bilder/Logo.png"  width="150px" height="150px"></image>
				<img src="Bilder/Titel.png" style="height:150px;"></image>			
			</div>			
		</div>		
		<div class='login'>
		
		
				<?php
			//URL Argumente
			
			//isset
			$user = $_POST["email"];
			$vorname = $_POST["vorname"];
			$nachname = $_POST["nachname"];
			$passwort = $_POST["passwort"];
			$passwort2 = $_POST["passwort2"];
			$wohnort = $_POST["wohnort"];
			$plz = $_POST["plz"];
			$date = $_POST["date"];
			
	/*		//Prüfen ob alle Daten vorhanden sind
			
			$allThere = false;
			if ($user && $vorname && $nachname && $passwort && $passwort2 && $wohnort && $plz && $date) {
				$allThere = true;
			}*/
			
			
			$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
			if($passwort == $passwort2) {
				$bool = false;
				$sql = "INSERT INTO `balbook`(`Passwort`, `Angemeldet`) VALUES ('".$passwort."',true)";
				$pdo->query($sql);
			}
			
			//Testen ob alle Datein da sind
			//Testen ob die Daten schon so sind
			//
			
			$sql = "INSERT INTO `balbook`( `Vorname`,`Angemeldet`) VALUES ('".$vorname."',true)";
			$pdo->query($sql);
			
			$sql = "INSERT INTO `balbook`(`Nachname`,`Angemeldet`) VALUES ('".$nachname."',true)";
			$pdo->query($sql);
		
			$sql = "INSERT INTO `balbook`(`Birthday`,`Angemeldet`) VALUES ('".$date."',true)";
			$pdo->query($sql);
			

			
			
			
			
			
			
			
			
			
			
			
			
			
			
			//Tests vor dem Registrieren
			$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
			if ($allThere == true) {
			if ($passwort == $passwort2) {
				$bool = false;
				$datum = explode("-", $date);
				$heute = date("m.d.y"); 
				$heute = explode(".", $heute);
				if ($datum[0]-$heute[2]-2000 <= 0) {
					$sql = "SELECT * FROM balbook WHERE email = '".$user."'";
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
						$sql = "INSERT INTO `balbook`( `Vorname`, `Nachname`, `Email`, `Passwort`, `PLZ`, `Birthday`, `Nummer`, `Angemeldet`) VALUES ('".$vorname."','".$nachname."','".$user."','".$passwort."','".$plz."','".$date."','".($nummer+1)."',true)";
						$pdo->query($sql);
						
						
						//LOG
						file_put_contents("log.txt",$user." hat sich um ".date("G:i:s")." registriert"."\n" , FILE_APPEND);
						
						header("Location: ../Homepage.php?email=".$user); 
						
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
		?>
		</div>
		<div class='regis'>
		
			<?php
				if ($bool == true) {
				echo '<form action="../LoginScreen.html" style="margin-top:5%">
					<button type="submit" ><h1>Fehlerhaft</h1></button>
					</form>';
				}
			?>
		
		</div>
		</div>
	
	</body>
</html>