<html>
	<head>
		<title>Homepage</title>
		<meta charset="utf-8"> 
		
	</head>
	<body>
	

			<?php
				session_start();
				$email = $_GET["email"];
			
				include("LoginTest.php");

				$pdo = new PDO('mysql:host=localhost;dbname=balbook', 'balbook', 'RasPIARDUINO_22');
				$pdo->query("SET NAMES 'utf8'");
				

				
				$UserID = $pdo->query("SELECT nummer FROM balbook WHERE email='".$email."'");
							foreach ($UserID as $row) {
								$UserID = $row[0];
							}
				
			
									
				$text = $_GET["antwort"];
				$GehtZu = $_GET["GehtZu"];
				
				//Kommentar ID
				$sql = $pdo->query('SELECT MAX(`Nummer`) FROM Unterkommentare');
				foreach ($sql as $row) {
					$id = $row[0];
				}
				$id = $id+1;
				
				$sql = "INSERT INTO `Unterkommentare`(`Nummer`, `GehtZu`, `UserID`, `Text`) VALUES ('".$id."','".$GehtZu."','".$UserID."','".$text."')";
					$pdo->query($sql);
					//LOG
					file_put_contents("log.txt","Kommentar von ".$email." um ".date("G:i:s")." am ".date("d. M y")."\n" , FILE_APPEND);
					
					//Zurück zur Homepage
					header("Location: ../Homepage.php?email=".$email."");
				
			?>
			

		
	</body>
</html>