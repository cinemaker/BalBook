<!DOCTYPE html>
<html>
<head>
	<title>Profil</title>
		<meta charset="utf-8"> 
		<link rel="stylesheet" type="text/css" href="Profil.css">

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

		<div class="Kopfzeile">
			<?php
				if ($modus == 2) {
					echo "<a href='Logout.php?id=".$_GET["id"]."'><h1> StudiK2 </h1></a>";	
				} else {
					echo "<a href='Loginscreen.php'><h1> StudiK2 </h1></a>";	
				}			
  			?>

			<!--links zu startseite-->

		</div>

	<div class="Sidebar" id="sidebar">
			
			
				<?php
					if ($modus >= 2) {
						echo "<a class='knopf' href='Homepage.php?id=".$_GET["id"]."'>Homepage</a>";
						echo "<br><br>";
						echo "<a class='knopf' href='Homepage.php?id=".$_GET["id"]."&email=".$_SESSION["email"]."'>Eigene Posts</a>";
						echo "<br><br>";
						echo "<a class='knopf' href='Logout.php?id=".$_GET["id"]."'>Ausloggen</a>";	

					} else {
						echo "<a class='knopf' href='Loginscreen.php'>Zurück</a>";
					}					
  				?>
			

		</div>

		<div>
		<!-- Profil -->
		<?php
				$pdo = new PDO('mysql:host=localhost;dbname=balbook', 'balbook', 'RasPIARDUINO_22');
				$pdo->query("SET NAMES 'utf8'");

				if ($modus >= 2) {
					$user = $_SESSION["email"];
				} else {
					$user = $_GET["email"];
				}

				$vorname = $pdo->query("SELECT vorname FROM balbook WHERE email = '$user'");
				foreach ($vorname as $row) {
					$vorname = $row[0];
				}
				
				$nachname = $pdo->query("SELECT nachname FROM balbook WHERE email = '$user'");
				foreach ($nachname as $row) {
					$nachname = $row[0];
				}
				
				$passwort = $pdo->query("SELECT passwort FROM balbook WHERE email = '$user'");
				foreach ($passwort as $row) {
					$passwort = $row[0];
				}
				
				$plz = $pdo->query("SELECT plz FROM balbook WHERE email = '$user'");
				foreach ($plz as $row) {
					$plz = $row[0];
				}
				
				$wohnort = $pdo->query("SELECT wohnort FROM wohnorte WHERE plz = '$plz'");
				foreach ($wohnort as $row) {
					$wohnort = $row[0];
				}
				
				$birthday = $pdo->query("SELECT birthday FROM balbook WHERE email = '$user'");
				foreach ($birthday as $row) {
					$birthday = $row[0];
				}
				echo '
				<form class="profil" action=""> 
				Name:<input type="text" name="Name" value="'.$vorname.' '.$nachname.'" readonly><br><br>
				Email:<input type="text" name="Email" value="'.$user.'" readonly><br><br>
				PLZ:<input type="number" name="PLZ" value="'.$plz.'" readonly><br><br>
				Wohnort:<input type="text" name="Wohnort" value="'.$wohnort.'" readonly><br><br>
				Geburtstag:<input type="date" name="geburtstag" value="'.$birthday.'" readonly><br><br>
				';

				if ($modus >= 2) {
					echo '<input class="abschicken" type="submit" name="andern" value="Ändern"></input>';
				}


				echo '</form>';
				?>	

				<?php 
				if ($modus >= 2) {
					echo "
					<script type='text/javascript'>
						document.getElementsByTagName('Input')[0].removeAttribute('readonly');
						document.getElementsByTagName('Input')[1].removeAttribute('readonly');
						document.getElementsByTagName('Input')[2].removeAttribute('readonly');
						document.getElementsByTagName('Input')[3].removeAttribute('readonly');
						document.getElementsByTagName('Input')[4].removeAttribute('readonly');
					</script>

				";
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