<html>
	<head>
		<title>Profil</title>
		<meta charset="utf-8"> 
		<link rel="stylesheet" href="stylesheet/Profil.css">
		<link rel="stylesheet" href="stylesheet/SurroundStyle.css">
	</head>
	<body>
		<div class='title'>			
			<div class='LangLebeDasKomIntern'>	
					<img src="bilder/Logo.png" width="150px" height="150px"></image>
					<img src="bilder/Titel.png" style="height:150px;" ></image>			
			</div>			
			<div style="float:top;">	
			</div>	
		</div>		
		<?php
		
			if (isset($_GET["id"])) {
				session_id($_GET["id"]);
				session_start();
				$user = $_SESSION["email"];
			
				include("scripts/LoginTest.php");
			
			
			
			echo '
				<div class="sidebar" align="center">
					<form action="scripts/Logout.php" style="margin-top:5%" class="button">
						<input type="text" name="email" value="'.$user.'" style="visibility:hidden"> 
						<button type="submit" >Ausloggen</button>
					</form>
					<form action="Homepage.php" style="margin-top:5%" class="button">
						<input type="text" name="email" value="'.$user.'" style="visibility:hidden"> 
						<button type="submit" >Homepage</button>
					</form>

				</div>';
			}
		?>
		
		<div class='linkeSeite'>
		
			
			<?php
				//PROFIL INFORMATIONEN
				function neueZeile($infos) {
					
					
				}
				
				
				$pdo = new PDO('mysql:host=localhost;dbname=balbook', 'balbook', 'RasPIARDUINO_22');
				$pdo->query("SET NAMES 'utf8'");
				$user = $_SESSION["email"];
				
				if (isset($_GET["email"])) {
					
					$user = $_GET("email");
					
				}
				
				$vorname = $pdo->query("SELECT vorname FROM balbook WHERE email = '". $user . "'");
				foreach ($vorname as $row) {
					$vorname = $row[0];
				}
				
				$nachname = $pdo->query("SELECT nachname FROM balbook WHERE email = '". $user . "'");
				foreach ($nachname as $row) {
					$nachname = $row[0];
				}
				
				$passwort = $pdo->query("SELECT passwort FROM balbook WHERE email = '". $user . "'");
				foreach ($passwort as $row) {
					$passwort = $row[0];
				}
				
				$plz = $pdo->query("SELECT plz FROM balbook WHERE email = '". $user . "'");
				foreach ($plz as $row) {
					$plz = $row[0];
				}
				
				$wohnort = $pdo->query("SELECT wohnort FROM wohnorte WHERE plz = '". $plz . "'");
				foreach ($wohnort as $row) {
					$wohnort = $row[0];
				}
				
				$birthday = $pdo->query("SELECT birthday FROM balbook WHERE email = '". $user . "'");
				foreach ($birthday as $row) {
					$birthday = $row[0];
				}


				
				echo '
				<img src="Bilder/Platzhalter.png"  height=“400px“>
 
				
				<table border="0" cellpadding="0" cellspacing="0" >
				
					<colgroup>
						<col width="100">
						<col width="100">
					</colgroup>
				
					<tr>
						<td> Vorname: </td>			<td> '.$vorname.' </td>
					</tr>
					
					<tr> 
						<td> Nachname: </td>		<td> '.$nachname.' </td>
					</tr>
					
					<tr> 
						<td> Geburtsdatum: </td>	<td> '.$birthday.' </td>
					</tr>
					
					<tr> 
						<td> E-Mail: </td>			<td> '.$user.' </td>
					</tr>
					
					<tr> 
						<td> Wohnort: </td>			<td> '.$plz.' '.$wohnort.' </td>
				</table>
				';
							
				
				
			echo '<div align=“center“>
					<form action="Daten_aendern.php" accept-charset="utf-8">
						<input type="text" name="email" value="'.$user.'" style="visibility:hidden">
						<input type="submit" value="Persönliche Daten ändern">
					</form>
				</div>';
				
			?>
				
								
				

		</div>
		
		
		<div class='rechteSeite'>		
		</div>
		
		
		
		
		<div class="bottomBar">
			<center>Copyright 2016</center>
			<center>Ein Projekt des Informatikkurs am Gymnasium Balingen</center>
			<center>Pascal Müller , Philipp Schanz</center>
			
			<center>StudieK2 © 2016</center>
			<center>Herr Schäfer übernimmt volle Haftung</center>
		</div>	
		
		
		
		
		
		<!-- JAVASCRIPT -->
		<script type="text/javascript">
	
		</script>
		
	</body>
</html>

