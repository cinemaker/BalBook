<!DOCTYPE html>
<html>
<head>
	<title>KommentareSchreiben</title>
</head>
<body>
	<?php
				$email = $_GET["email"]; 
				$idUser = $_GET["id"];
				$modus = $_GET["modus"];
								
				$pdo = new PDO('mysql:host=localhost;dbname=balbook', 'balbook', 'RasPIARDUINO_22');
				$pdo->query("SET NAMES 'utf8'");
				$sql = "SELECT angemeldet FROM balbook WHERE email = '$email'";	

				foreach ($pdo->query($sql) as $row) {
					$sql = false; 
				}
				if ($sql) { 
					//ausloggen
					header("Location: Loginscreen.php");
				}

				
				$UserID = $pdo->query("SELECT nummer FROM balbook WHERE email='$email'");
				foreach ($UserID as $row) {
					$UserID = $row[0];
				}
				

				$uhrzeit = date("G:i");
				
				$date = date("Y-m-d");
									
				$text = $_GET["comment"];

				
				//Kommentar ID
				$sql = $pdo->query('SELECT MAX(`ID`) FROM kommentare');
				foreach ($sql as $row) {
					$idZahl = $row[0];
				}
				$idZahl = $idZahl+1;
				
				$sql = "INSERT INTO `kommentare`(`UserID`, `Uhrzeit`, `Datum`, `Text`,`Id`) VALUES ('$UserID','$uhrzeit','$date','$text',$idZahl)";
				$pdo->query($sql);
				//LOG
				file_put_contents("log.txt","Kommentar von '$email' um ".date("G:i:s")." am ".date("d. M y")."\n" , FILE_APPEND);
						
					//Zurück zur Homepage
					if ($modus == 2 or $modus == "2") {
						header("Location: Homepage.php?id=$idUser");	
					} else {
						header("Location: Homepage.php?id=$idUser&email=$email");
					}
					
				
			?>
</body>
</html>