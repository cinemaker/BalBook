<html>
	<head>
		<title>Homepage</title>
		<meta charset="utf-8"> 
		
	</head>
	<body>
	

		<div class='linkeSeite'>

			<?php
				session_start();
				$email = $_SESSION["email"];
			
				include("LoginTest.php");

				$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
				$pdo->query("SET NAMES 'utf8'");
				

				
				$UserID = $pdo->query("SELECT nummer FROM balbook WHERE email='".$email."'");
							foreach ($UserID as $row) {
								$UserID = $row[0];
							}
				
				$uhrzeit = date("G:i");
				
				$date = date("Y-m-d");
									
				$text = $_SESSION["comment"];
				echo $email;
				echo $text;
				
				//Kommentar ID
				/*$sql = $pdo->query('SELECT MAX(`ID`) FROM Kommentare');
				foreach ($sql as $row) {
					$id = $row[0];
				}
				$id = $id+1;
				
				$sql = "INSERT INTO `Kommentare`(`UserID`, `Uhrzeit`, `Datum`, `Text`,`Id`) VALUES ('".$UserID."','".$uhrzeit."','".$date."','".$text."',".$id.")";
					$pdo->query($sql);
					//LOG
					file_put_contents("log.txt","Kommentar von ".$email." um ".date("G:i:s")." am ".date("d. M y")."\n" , FILE_APPEND);
					
					//Zurück zur Homepage
					header("Location: ../Homepage.php?email=".$email."");
				*/
			?>
		</div>

		
		
	</body>
</html>

