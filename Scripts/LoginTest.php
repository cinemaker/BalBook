<html>
	<head>
		<meta charset="utf-8"> 
	</head>
	<body>
		<?php
			//LOGIN CHECK
			$email = $_SESSION["email"];
			$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
			$sql = "SELECT angemeldet FROM balbook WHERE email = '". $email . "'";	
			foreach ($pdo->query($sql) as $row) {
				$sql = false; 
				//if (!$row['angemeldet']) { header("Location: ../Logout.php?email=".$_POST["email"].""); 
				//	} 
			}
			if ($sql) { header("Location: ../Logout.php?email=".$email.""); }
		?>
	</body>
</html>

