<html>
	<head>
		<title>Homepage</title>
		<meta charset="utf-8"> 
		
	</head>
	<body>
	

		<div class='linkeSeite'>

			<?php
				//LOGIN CHECK
				$pdo = new PDO('mysql:host=localhost;dbname=balbook', 'balbook', 'RasPIARDUINO_22');
				$sql = "SELECT angemeldet FROM balbook WHERE email = '". $_POST["email"] . "'";	
				foreach ($pdo->query($sql) as $row) {
					$sql = false; 
					if (!$row['angemeldet']) { header("Location: Logout.php?email=".$_POST["email"].""); 
						} 
				}
				if ($sql) { header("Location: Logout.php?email=".$_POST["email"].""); }
			?>
			
			
			<?php
			
				$date = date("d.m.y");
			
				$Speicherort = "Nachrichten/".$date.".txt";

					
					$text = $_POST["comment"];
					$user = $_POST["email"];
					$uhrzeit = $heute = date("G:i");
					
					//StartBlock wird geschrieben
						$textdatei = file_put_contents($Speicherort,"#START"."\n" , FILE_APPEND);
					//Email des Users
						$textdatei = file_put_contents($Speicherort,"#".$user."\n", FILE_APPEND);
					//Uhrzeit
						$textdatei = file_put_contents($Speicherort,"#".$uhrzeit."\n", FILE_APPEND);
					//Eigentliche Nachricht
						$textdatei = file_put_contents($Speicherort,"#".$text.PHP_EOL."\n", FILE_APPEND);	
					//Spezielle Nummer
						$nummer = file("Nachrichten/nummer.txt")[0]+1;
						$textdatei = file_put_contents($Speicherort,"#".$nummer."\n", FILE_APPEND);	
						//Nummer um eins erhöhen
						file_put_contents("Nachrichten/nummer.txt",$nummer);	
					//EndBlock wird geschrieben
						$textdatei = file_put_contents($Speicherort,"#ENDE\n", FILE_APPEND);
					
					//LOG
					file_put_contents("log.txt","Kommentar von ".$user." um ".date("G:i:s")."\n" , FILE_APPEND);
					
					//Zurück zur Homepage
					header("Location: Homepage.php?email=".$_POST["email"]."");
			
			?>
		</div>

		
		
	</body>
</html>

