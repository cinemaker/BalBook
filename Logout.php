<!DOCTYPE html>
<html>
<head>
	<title>Logout</title>
</head>
<body>
	<?php 
		session_id($_GET["id"]);
		session_start();
		session_destroy();

		$pdo = new PDO('mysql:host=localhost;dbname=balbook', 'balbook', 'RasPIARDUINO_22');
				
				$angemeldet = "UPDATE balbook SET angemeldet = 0 WHERE nummer = ".$_GET['id'];
				$pdo->query($angemeldet);
		
		header("Location: Loginscreen.php");
	 ?>
</body>
</html>