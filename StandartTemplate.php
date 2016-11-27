<html>
	<head>
		<title>Homepage</title>
		<meta charset="utf-8"> 
		<link rel="stylesheet" href="stylesheet/SurroundStyle.css">
		<link rel="stylesheet" href="stylesheet/Homepage.css">
	</head>
	<body onload="adapt()">
		<div class='title'>			
			<div class='LangLebeDasKomIntern'>	
					<img src="Bilder/Logo.png" width="150px" height="150px"></image>
					<img src="Bilder/Titel.png" style="height:150px;" ></image>			
			</div>			
			<div style="float:top;">	
			</div>	
		</div>		
		<?php
		$user = "NULLVALUE";
		echo '<div class="sidebar" id="sidebar" align="center">
				<form action="scripts/Logout.php" style="margin-top:5%">
					<input type="text" name="email" value="'.$user.'" style="visibility:hidden"> 
					<button class="sidebar" type="submit" >Ausloggen</button>
			    </form>
				<form action="Profil.php" style="margin-top:5%">
					<input type="text" name="email" value="'.$user.'" style="visibility:hidden"> 
					<button class="sidebar" type="submit" >Profil anzeigen</button>
			    </form>
			  </div>';
		
		?>
		
		<?php
			session_id($_GET("id"));
			session_start();
			$email = $_SESSION["email"];
			
			include("LoginTest.php");
		?>
		
		
		<div class='linkeSeite' id='linkeSeite'>

		</div>
		<div class='rechteSeite' id="rechteSeite">

			
			<div class="freunde">
					
		
			</div>
			
		</div>
		

		
		<div class="bottomBar">
			<center>Copyright 2016</center>
			<center>Ein Projekt des Informatikkurs am Gymnasium Balingen</center>
			<center>Pascal Müller , Philipp Schanz</center>
			
			<center>StudieK2 © 2016</center>
			<center>Herr Schäfer übernimmt volle Haftung ;D</center>
		</div>
		
		<!-- JAVASCRIPT -->
		<script type="text/javascript">
		
		</script>
	</body>
</html>