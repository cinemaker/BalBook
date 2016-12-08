<html>
	<head>
		<title>Homepage</title>
		<meta charset="utf-8"> 
		<link rel="stylesheet" href="stylesheet/SurroundStyle.css">
		<link rel="stylesheet" href="stylesheet/Homepage.css">
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
			
			session_id($_GET["id"]);
			session_start();
			$email = $_SESSION["email"];
			$user = $email;
			include("scripts/LoginTest.php");
			
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
		
		<div class='linkeSeite' id='linkeSeite'>
<?php
				//NACHRICHTEN LADEN
			
				/////////////////////////FUNKTION//////////////////////////
				function KommentareAuslesen($JetzigeAnzahl,$NachrichtenAnzahl) {
					
					$pdo = new PDO('mysql:host=localhost;dbname=balbook', 'balbook', 'RasPIARDUINO_22');
					$pdo->query("SET NAMES 'utf8'");
					
					$startPunkte = array();
					$endPunkte = array();
					$textlength = 500;
					
					//höchste ID finden
					$sql = $pdo->query('SELECT MAX(`ID`) FROM Kommentare');
					foreach ($sql as $row) {
						$id = $row[0];
					}
					while ($JetzigeAnzahl < $NachrichtenAnzahl) {
						
						if ($id <= 0) {
							//Keine Kommentare mehr vorhanden
						} else {
							
							$UserID = $pdo->query("SELECT UserID FROM Kommentare WHERE id=".$id);
							foreach ($UserID as $row) {
								$UserID = $row[0];
							}
							
							$email = $pdo->query("SELECT email FROM balbook WHERE nummer=".$UserID);
							foreach ($email as $row) {
								$email = $row[0];
							}
							$vorname = $pdo->query("SELECT vorname FROM balbook WHERE email='".$email."'");
							foreach ($vorname as $row) {
								$vorname = $row[0];
							}
							
							$nachname =  $pdo->query("SELECT nachname FROM balbook WHERE email='".$email."'");
							foreach ($nachname as $row) {
								$nachname = $row[0];
							}
							
							$uhrzeit = $pdo->query("SELECT uhrzeit FROM Kommentare WHERE id=".$id); 
							foreach ($uhrzeit as $row) {
								$uhrzeit = $row[0];
							}
							
							$text =  $pdo->query("SELECT text FROM Kommentare WHERE id=".$id);
							foreach ($text as $row) {
								$text = $row[0];
							}		
								
							$info = "von ".$vorname." ".substr($nachname,0,1)."."." gepostet um ".$uhrzeit." Uhr";
							$nachricht = $text;
							
							$KommentarNum = $JetzigeAnzahl;
							//KOMMENTAR AUSGABE
								if (strlen($nachricht) >= $textlength) {
									$nachricht = substr($nachricht, 0, $textlength) . "<a onclick='komplettenTextanzeigen(" .$KommentarNum.  ");return(false);' href='#' id='".$KommentarNum."link'>" . "..." . "</a>" . "<span class='hiddentext' id='".$KommentarNum."'>" . substr($nachricht, $textlength) . "</span>";
								}
								echo '
								<div class="nachricht" id="'.$KommentarNum.'text'.'">
									<p class="text">'.$nachricht.'</p>
									<div>
									<p class="info infoArea">'.$info.'</p>
									<a class="antworten infoArea" href="#" id="'.$KommentarNum.'antwort" onclick="antworten('.$KommentarNum.',true);return(false);">Antworten</a>
									<a class="kommentareLaden infoArea" href="#" onclick="kommentareLaden('.$KommentarNum.');return(false);"> Kommentare</a>
									</div>
									
									<div class="kommentare infoArea" id="'.$KommentarNum.'kommentarArea"> </div>
									<br>
									<div class="kommentarAdden" id="'.$KommentarNum.'kommentarAdden" style="margin-top:-90px; position:relative; z-index:-10; visibility:hidden">
										<form action="AntwortSchreiben.php" class="kommentarAdden">
											<div style="width:0px"><input type="text" name="email" value="'.$_SESSION['email'].'" style="visibility:hidden;"> </div>
											<textarea name="antwort" style="margin-top:-15px; width:100%;" maxlength="150" required></textarea>
					
											<button style="width:100%; type="submit">Posten</button>
										</form>
									</div>
									<div class="filler2" id="'.$KommentarNum.'filler" style="margin-bottom:0px"> </div>
								</div>';
							
							//KOMMENTAR AUSGABE
						}
						$JetzigeAnzahl = $JetzigeAnzahl + 1;
						$id = $id - 1;
					}
				
				
							
								
				}
				
				
				/////////////////////////FUNKTION//////////////////////////
				
			
				
				//Durch Freundesliste durchgehen
								
				//Normalwert = 20
				$NachrichtenAnzahl = 20;
				
				if (isset($_GET["nachrichtenAnzahl"])) {
					$NachrichtenAnzahl = $_GET["nachrichtenAnzahl"];
				}
				
				$JetzigeAnzahl = 0;
				$JetzigeAnzahl = KommentareAuslesen($JetzigeAnzahl,$NachrichtenAnzahl);
				$counter = 0;				
				
				
				//MEHR KOMMENTARE ANZEIGEN
				echo '
					<div class="mehrKommentareLaden">
						<br>
						<center>
						<a class="mehrKommentareLaden" href="Homepage.php?email='.$email.'&id='.$_GET["id"].'&nachrichtenAnzahl='.($NachrichtenAnzahl+20).'" >Mehr Kommentare laden</a>
						</center>
					</div>';
			?>
			
			
			<?php
				//KOMMENTARE ANHÄNGEN
				//for ($i = 0; $i < $KommentarNum; $i++) {
					
					
				//}
			
			?>
		</div>
		<div class='rechteSeite' id="rechteSeite">
		
			<div class="freunde">
			<!-- Freundesliste auf der rechten Seite -->
				<?php^
			
			
			
			
			
			
			
			
			
			
			
			
			
				?>
			</div>
		
			<div class="textbox" style="height:500px">
				<?php
				echo '
				<form action="scripts/KommentarSchreiben.php" class="button" method="GET">
					<input type="text" name="email" value="'.$_SESSION["email"].'" style="visibility:hidden"> 
					<textarea name="comment" style="width:100%; height:90%; margin-top:-21px" maxlength="1500" required></textarea>
					
					<button style="width:100%; height:10%" type="submit">Posten</button>
				</form>';
				?>
			</div>
			
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
			function komplettenTextanzeigen(nummer) {
				//document.getElementById(nummer.toString()).style['height']='0px';
				document.getElementById(nummer.toString()).style.display='inline';
				
				var element = document.getElementById(nummer.toString().concat("link"));
				element.parentNode.removeChild(element);
				document.getElementById("sidebar").style['height']=document.getElementById("linkeSeite").clientHeight+"px";	
				document.getElementById("rechteSeite").style['height']=document.getElementById("linkeSeite").clientHeight+"px";
				
			}
			
			function kommentareLaden(nummer) {
				
			}
			
			
			function antworten(nummer,bool) {
				if (bool == true) {
					document.getElementById(nummer.toString().concat("antwort")).onclick= function(){
																								antworten(nummer,false);
																								return(false);
																							};
					document.getElementById(nummer.toString().concat("kommentarAdden")).style.display='inline';
		
					document.getElementById(nummer.toString().concat("kommentarAdden")).style.visibility='visible';
				
					document.getElementById(nummer.toString().concat("filler")).style.marginBottom='0';
			
				} else {
					document.getElementById(nummer.toString().concat("antwort")).onclick= function(){
																								antworten(nummer,true);
																								return(false);
																							};
					document.getElementById(nummer.toString().concat("kommentarAdden")).style.display='none';
					document.getElementById(nummer.toString().concat("kommentarAdden")).style.visibility='hidden';
					
					document.getElementById(nummer.toString().concat("filler")).style.marginBottom='-10px';
				}		
				document.getElementById("sidebar").style['height']=document.getElementById("linkeSeite").clientHeight+"px";	
				document.getElementById("rechteSeite").style['height']=document.getElementById("linkeSeite").clientHeight+"px";
			}
			
			document.getElementById("sidebar").style['height']=document.getElementById("linkeSeite").clientHeight+"px";	
			document.getElementById("rechteSeite").style['height']=document.getElementById("linkeSeite").clientHeight+"px";
			
		</script>
		
	</body>
</html>