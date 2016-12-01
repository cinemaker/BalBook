<html>
	<head>
		<title>LoginScreen</title>
		<meta charset="utf-8"> 
	</head>
	<body>
		
		<?php
			//URL Argumente
			//DAS MUSS SO BLEIBEN
			$user = $_GET["email"];
			
			//Query
			$pdo = new PDO('mysql:host=localhost;dbname=balbook', 'balbook', 'RasPIARDUINO_22');
			$pdo->query("SET NAMES 'utf8'");
			
			$sql = "UPDATE balbook SET angemeldet = 0 WHERE email = '". $user . "'";
			
			$pdo->query($sql);
			
			//LOG
			file_put_contents("log.txt",$user." hat sich um ".date("G:i:s")." am ".date("d. M y")." ausgeloggt"."\n" , FILE_APPEND);
			
			header("Location: ../LoginScreen.html"); 
		?>
	</body>
</html>