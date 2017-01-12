<html>
	<head>
		<title>Homepage</title>
		<meta charset="utf-8"> 
		<link rel="stylesheet" type="text/css" href="Homepage.css">



	</head>
	<body>
		<?php 	
			$modus = 0;
			if (isset($_GET["email"])) {
				$modus = $modus + 1;
			}
			if (isset($_GET["id"])) {
				session_id($_GET["id"]);
				session_start();
				$modus = $modus + 2;
			} 
			if ($modus == 0) {
				header("Location: Loginscreen.php");
			}
		?>


		<!-- Kopfzeile -->		
		<div class="Kopfzeile">
			<?php
				if ($modus >= 2) {
					echo "<a href='Logout.php?id=".$_GET["id"]."'><h1> StudiK2 </h1></a>";	
				} else {
					echo "<a href='Loginscreen.php'><h1> StudiK2 </h1></a>";	
				}			
  			?>

			<!--links zu startseite-->

		</div>

		<!-- Sidebar -->
		<div class="Sidebar" id="sidebar">
			<!--link zu profil-->
			<?php
				if ($modus == 1) {
					echo '
					<a class="knopf" href="Profil.php?email='.$_GET["email"].'">Profil</a>
						';
				} else if ($modus == 2) {
					echo '
					<a class="knopf" href="Profil.php?id='.session_id().'">Profil</a>
						';
				} else {
					echo '
					<a class="knopf" href="Profil.php?id='.session_id().'?email='.$_GET["email"].'">Profil</a>
						';
				}

			?>
			<br><br>
				<?php
					if ($modus >= 2) {
						if ($modus == 2) {
							echo "<a class='knopf' href='Homepage.php?id=".$_GET["id"]."&email=".$_SESSION["email"]."'>Eigene Posts</a>";
							echo "<br><br>";
						} else {
							echo "<a class='knopf' href='Homepage.php?id=".$_GET["id"]."'>Homepage</a>";
							echo "<br><br>";
						} 

						echo "<a class='knopf' href='Logout.php?id=".$_GET["id"]."'>Ausloggen</a>";	

					}						
  				?>
			

		</div>
		<!-- Freundesliste -->
		<div class="Freundesliste">
			<!--wenn angemeldet-->

		</div>
		<!-- Kommentars schreiben -->	
		<div class="Kommentareschreiben"> 
			<!--wenn angemeldet-->
			<?php 
				if ($modus >= 2) {
					if ($modus == 2) {


						echo '
							<form  action="Kommentareschreiben.php" accept-charset="utf-8" method="GET"> 
								<input type="text" name="email" value="'.$_SESSION["email"].'" style="visibility:hidden"> 
								<textarea class="Kommentareschreiben" name="comment" maxlength="1500" required></textarea>
						
								<button class="posten Kommentareschreiben" type="submit">Posten</button>

							</form>
						';
					} else {
						echo '
							<form  action="Kommentareschreiben.php" accept-charset="utf-8" method="GET"> 
								<input type="text" name="email" value="'.$_GET["email"].'" style="visibility:hidden"> 
								<textarea class="Kommentareschreiben" name="comment" maxlength="1500" required></textarea>
						
								<button class="posten Kommentareschreiben" type="submit">Posten</button>

							</form>
						';
					}
				}
			?>
				 	
		</div>
		<!-- Kommentare -->			
		<div class="Kommentare" id="kommentare">
			<!--if angemeldet => andere kommentare anzeigen
			if not angemeldet => nur user kommentare anzeigen-->
			<?php 
				if ($modus == 2) {
					$email = $_SESSION["email"];
					
					$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
					$sql = "SELECT angemeldet FROM balbook WHERE email = '". $email . "'";	

					foreach ($pdo->query($sql) as $row) {
					$sql = false; 
					}
					if ($sql) { 
						//ausloggen
						session_write_close();
						header("Location: Loginscreen.php");
					}
					//_________________________________________
					// ALLE KOMMENTARE ANZEIGEN 
					//_________________________________________
					
					if (isset($_GET["nachrichtenAnzahl"])) {
						$nachrichtenAnzahl = $_GET["nachrichtenAnzahl"];
					} else {
						$nachrichtenAnzahl = 20;
					}
					
					$_SESSION["nachrichtenAnzahl"] = $nachrichtenAnzahl;
					KommentareAuslesen(0,$nachrichtenAnzahl,false);
					
				} else {
					//_________________________________________
					// EIGENE KOMMENTARE ANZEIGEN 
					//_________________________________________
					if (isset($_GET["nachrichtenAnzahl"])) {
						$nachrichtenAnzahl = $_GET["nachrichtenAnzahl"];
					} else {
						$nachrichtenAnzahl = 20;
					}
					
					$_SESSION["nachrichtenAnzahl"] = $nachrichtenAnzahl;
					if ($modus == 3) {
						KommentareAuslesen(0,$nachrichtenAnzahl,true);	
					} else {
						KommentareAuslesen(0,$nachrichtenAnzahl,false);
					}
					
					
				}





				function KommentareAuslesen($JetzigeAnzahl, $NachrichtenAnzahl,$Eigen) {
					$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
					$pdo->query("SET NAMES 'utf8'");
					$textlength = 500;
					//höchste ID finden
					$sql = $pdo->query('SELECT MAX(`ID`) FROM Kommentare');
					foreach ($sql as $row) {
						$id = $row[0];
					}

					while ($JetzigeAnzahl < $NachrichtenAnzahl) {
						
						if ($id <= 0) {
							//Keine Kommentare mehr vorhanden
						} else {
							
							$UserID = $pdo->query("SELECT UserID FROM kommentare WHERE id=".$id);
							foreach ($UserID as $row) {
								$UserID = $row[0];
							} 

							if ($Eigen == 0 or ($Eigen == 1 and $UserID == session_id())) {
							
								$email = $pdo->query("SELECT email FROM balbook WHERE nummer=".$UserID);
								foreach ($email as $row) {
									$email = $row[0];
								}

								$vorname = $pdo->query("SELECT vorname FROM balbook WHERE email='".$email."'");
								foreach ($vorname as $row) {
									$vorname = $row[0];
								}
								
								$nachname =  $pdo->query("SELECT nachname FROM balbook WHERE email='".$email."'");
								foreach ($nachname as $row) {
									$nachname = $row[0];
								}
								
								$uhrzeit = $pdo->query("SELECT uhrzeit FROM kommentare WHERE id=".$id); 
								foreach ($uhrzeit as $row) {
									$uhrzeit = $row[0];
								}
								
								$text =  $pdo->query("SELECT text FROM kommentare WHERE id=".$id);
								foreach ($text as $row) {
									$text = $row[0];
								}		
									
								$info = "von ".$vorname." ".substr($nachname,0,1)."."." gepostet um ".$uhrzeit." Uhr";
								$nachricht = $text;
								
								$KommentarNum = $JetzigeAnzahl;
									
								//KOMMENTAR AUSGABE
									//if (strlen($nachricht) >= $textlength) {
									//	$nachricht = substr($nachricht, 0, $textlength) . "<a onclick='komplettenTextanzeigen(" .$KommentarNum.  ");return(false);' href='#' id='".$KommentarNum."link'>" . "..." . "</a>" . "<span class='hiddentext' id='".$KommentarNum."'>" . substr($nachricht, $textlength) . "</span>";
									//}
									echo '
									<div class="nachricht" id="Kommentar_'.$KommentarNum.'">
										<p class="text">'.$nachricht.'</p>
										<p class="info">'.$info.'</p>

										<a class="links" href="">Antworten</a>
										<a class="links" href="">Kommentare</a>
									</div>';
							} 

						}
						$JetzigeAnzahl = $JetzigeAnzahl + 1;
						$id = $id - 1;
					}
				}

			?>
		</div>
		<div class="mehrKommentareLaden">
			<?php
				if ($modus == 1) {
					echo '
					<br>
					<center>
					<a class="mehrKommentareLaden" href="http://localhost/test/Balbook2/Homepage.php?email='.$_GET["email"].'&nachrichtenAnzahl='.($nachrichtenAnzahl+20).'" >Mehr Kommentare laden</a>
					</center>
					';
					//session_destroy();
				} else if ($modus == 2) {
					echo '
					<br>
					<center>
					<a class="mehrKommentareLaden" href="http://localhost/test/Balbook2/Homepage.php?id='.session_id().'&nachrichtenAnzahl='.($_SESSION["nachrichtenAnzahl"]+20).'" >Mehr Kommentare laden</a>
					</center>
					';
					//session_destroy();
				} else {
					echo '
					<br>
					<center>
					<a class="mehrKommentareLaden" href="http://localhost/test/Balbook2/Homepage.php?id='.session_id().'&email='.$_GET["email"].'&nachrichtenAnzahl='.($_SESSION["nachrichtenAnzahl"]+20).'" >Mehr Kommentare laden</a>
					</center>
					';
					//session_destroy();
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
		<script type="text/javascript">
			window.onload = function() {
				document.getElementByID("sidebar").style["height"]=document.documentElement.scrollHeight+"px";	
			}
		</script>
	</body>
</html>