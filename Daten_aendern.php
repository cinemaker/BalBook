<html>
	<head>
		<title>Profil</title>
		<meta charset="utf-8"> 
		<link rel="stylesheet" href="Stylesheet/Profil.css">
		<link rel="stylesheet" href="Stylesheet/SurroundStyle.css">
	</head>
	<body>
		<div class='title'>			
			<div class='LangLebeDasKomIntern'>	
					<img src="Bilder/Logo.png" width="150px" height="150px"></image>
					<img src="Bilder/Titel.png" style="height:150px;" ></image>			
			</div>			
			<div style="float:top;">	
			</div>	
		</div>		
		<?php
		
			session_id($_GET("id"));
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
		?>
		
		<div class='linkeSeite'>

			<form action="scripts/Daten_umschreiben.php" accept-charset="utf-8" style="margin-left:20px;margin-top:20px;margin-right:10px">
				

				Vorname: 
				<input type="text" name="vorname" placeholder="Vorname" style="width:40%;float:right">
				<br>
				<br>
				Nachname: 
				<input type="text" name="nachname" placeholder="Nachname" style="width:40%;float:right">
				<br>
				<br>
				Geburtstag: 
				<input type="date" name="date" placeholder="Geburtstag" style="width:40%;float:right;">
				<br>
				<br>
				<br>
				PLZ: <input type="number" name="plz" placeholder="PLZ" style="width:40%;float:right">
				<br>
				<br>
				Wohnort:
				<input type="text" name="wohnort" placeholder="Wohnort" style="width:40%;float:right">
				<br>
				<br>	
				<br>
				Neues Passwort:<input type="password" name="passwort" placeholder="Passwort" style="width:40%;float:right">
				<br>
				<br>
				Neues Passwort wiederholen:<input type="password" name="passwort2" placeholder="Passwort wiederholen" style="width:40%;float:right">
				<br>
				<br>
			  
			  <br><br>
			  <input type="submit" value="Registrieren">
			  
		
			</form>
		

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
		
		

		
	</body>
</html>
