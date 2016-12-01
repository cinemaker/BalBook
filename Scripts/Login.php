<html>
	<head>
		<meta charset="utf-8"> 
	</head>
	<body>



		<?php
			$bool = false;
			
			//URL Argumente
			$user = $_POST["email"];
			$password = $_POST["password"];
			
			
			
			//Query
			$pdo = new PDO('mysql:host=localhost;dbname=balbook', 'balbook', 'RasPIARDUINO_22');
			$pdo->query("SET NAMES 'utf8'");
			
			$sql = "SELECT * FROM balbook WHERE email = '". $user . "'";

			foreach ($pdo->query($sql) as $row) {
			   if ($row['Passwort'] == $password) {
				   //Passwort stimmt, User wird angemeldet
				   $angemeldet = "UPDATE balbook SET angemeldet = 1 WHERE email = '". $user . "'";
				   $pdo->query($angemeldet);
				   
				  
				   
				   
				   	//LOG
					file_put_contents("log.txt",$user." hat sich um ".date("G:i:s")." angemeldet am ".date("d. M y")."\n" , FILE_APPEND);
					
					//ID
					$id = $pdo->query("SELECT nummer FROM balbook WHERE email = '". $user . "'");
					foreach ($id as $row) {
						$id = $row[0];
					}
					
					
					//Session Variablen
					session_id($id);
					session_start();
					$_SESSION["email"] = $user;
					$_SESSION["passwort"] = $password;
					
				    header("Location: ../Homepage.php?id=".$id); 
				   $bool = true;
			   } else {
				   //Passwort stimmt nicht
				   header("Location: ../LoginScreen.html"); 
			   }
			}
			if ($bool == false) {
				header("Location: ../LoginScreen.html"); 
			}
				
		?>
	</body>
</html>