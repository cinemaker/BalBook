<html>
	<head>
		<meta charset="utf-8"> 
	</head>
	<body>
		<?php
			//LOGIN CHECK
			if (isset($_SESSION["email"])) {
				$email = $_SESSION["email"];
			} else {
				$email = $_GET["email"];
			}
			
			$pdo = new PDO('mysql:host=localhost;dbname=balbook', 'balbook', 'RasPIARDUINO_22');
			$sql = "SELECT angemeldet FROM balbook WHERE email = '". $email . "'";	
			foreach ($pdo->query($sql) as $row) {
				$sql = false; 
				if (!$row['angemeldet']) { header("Location: ../Logout.php?email=".$_POST["email"].""); 
					} 
			}
			if ($sql) { header("Location: ../Logout.php?email=".$email.""); }
		?>
	</body>
</html>

