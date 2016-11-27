<html>
	<head>
		<title>Homepage</title>
		<meta charset="utf-8"> 
		<link rel="stylesheet" href="SurroundStyle.css">
		<link rel="stylesheet" href="Homepage.css">
	</head>
	<body>
		<div class='title'>			
			<div class='LangLebeDasKomIntern'>	
					<img src="Logo.png" width="150px" height="150px"></image>
					<img src="Titel.png" style="height:150px;" ></image>			
			</div>			
			<div style="float:top;">	
			</div>	
		</div>		
		<?php
		$user = $_POST["email"];
		
		echo '<div class="sidebar" id="sidebar" align="center">
				<form action="Logout.php" style="margin-top:5%">
					<input type="text" name="email" value="'.$user.'" style="visibility:hidden"> 
					<button class="sidebar" type="submit" >Ausloggen</button>
			    </form>
				<form action="Profil.php" style="margin-top:5%">
					<input type="text" name="email" value="'.$user.'" style="visibility:hidden"> 
					<button class="sidebar" type="submit" >Profil anzeigen</button>
			    </form>
				<form action="Telefon.php" style="margin-top:5%">
					<input type="text" name="email" value="'.$user.'" style="visibility:hidden"> 
					<button class="sidebar" type="submit" >Telefon</button>
			    </form>
			  </div>';
		?>
		
		<div class='linkeSeite' id='linkeSeite'>

			<?php
				include("LoginTest.php");
			?>
			
			<?php
				//NACHRICHTEN LADEN
			
				/////////////////////////FUNKTION//////////////////////////
				function OutOfTime($Zeit) {
					
					//Bsp.: 20.01.16 => 19.01.16
					//Aufsplitten
					$Daten = [substr($Zeit,0,2),substr($Zeit,3,2),substr($Zeit,6,2)];
					If ($Daten[0] > 10) {
						$Daten[0] = $Daten[0] - 1;
					} elseif ($Daten[0] > 1) {
						$Daten[0] = "0".($Daten[0] - 1);
					} else {
						//Einen Monat zurück
						$Daten[0] = 31;
						if ($Daten[1] > 10) {
							$Daten[1] = $Daten[1] - 1;
						} elseif ($Daten[1] > 1) {
							$Daten[1] = "0".($Daten[1] - 1);
						} else {
							//Ein Jahr zurück
							$Daten[1] = 12;
							$Daten[2] = $Daten[2] - 1;
							$Ergebnis = ($Daten[0]).".".($Daten[1]).".".($Daten[2]);
							return false;
						}
					}
					
					$Ergebnis = ($Daten[0]).".".($Daten[1]).".".($Daten[2]);
					
					
					return $Ergebnis;
					
				}
				
				
				
				function TestObDa($Speicherort,$date) {
					if ($date==false) {} else {
						if (file_exists($Speicherort)) {
							//gut
						} else {
							$Speicherort = "Nachrichten/".OutOfTime($date).".txt";
							TestObDa($Speicherort, OutOfTime($date));
							//echo $date."\n";
						}
					}
				}
				
				function KommentareAuslesen($Speicherort,$JetzigeAnzahl,$NachrichtenAnzahl) {
					
					
					$startPunkte = [];
					$endPunkte = [];
					$textlength = 500;
					
						
					
					if (file_exists($Speicherort)) {
						
						$lines = file($Speicherort);

						// Durchgehen des Arrays und START und ENDE Blöcke finden
						foreach ($lines as $line_num => $line) {
							 if ($line == "#START\n") {
								 //START PUNKTE
								 //werden in umgekehrer Reihenfolge in die Tabelle eingefügt, damit neue Kommentare oben stehen
								 array_unshift($startPunkte, $line_num); 	 
							 }
							 
							 if ($line == "#ENDE\n") {
								 //ENDE PUNKTE
								 array_unshift($endPunkte, $line_num);
							 }
						}
						
						foreach ($startPunkte as $KommentarNum => $StartPos) {
							
							$vonWem = substr($lines[$StartPos+1],1);
							$Wann = substr($lines[$StartPos+2],1);
							
							$info = "von ".$vonWem." gepostet um ".$Wann." Uhr";
							
							//NACHRICHT
							$differenz = $endPunkte[$KommentarNum] - $StartPos;
							$differenz = $differenz - 5;
							$anfangDesTexts = $lines[$StartPos+3];
							
							$nachricht = substr($anfangDesTexts,1);
							
							for ($i = 1; $i <= $differenz; $i++) {
								$nachricht = $nachricht . "<br>" . $lines[$StartPos+3+$i];
							}
							
							$KommentarNum = $JetzigeAnzahl;
							
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
									<!--<div class="filler infoArea"> </div>-->
									
									<div class="kommentare infoArea" id="'.$KommentarNum.'kommentarArea"> </div>
									<br>
									<div class="kommentarAdden" id="'.$KommentarNum.'kommentarAdden" style="margin-top:-90px; position:relative; z-index:-10; visibility:hidden">
										<form action="AntwortSchreiben.php" class="kommentarAdden">
											<div style="width:0px"><input type="text" name="email" value="'.$_POST["email"].'" style="visibility:hidden;"> </div>
											<textarea name="antwort" style="margin-top:-15px; width:100%;" maxlength="150" required></textarea>
					
											<button style="width:100%; type="submit">Posten</button>
										</form>
									</div>
									<div class="filler2" id="'.$KommentarNum.'filler" style="margin-bottom:10px"> </div>
								</div>';
								
								
							$JetzigeAnzahl = $JetzigeAnzahl + 1;
							if ($JetzigeAnzahl == $NachrichtenAnzahl) {
								break;
							}
						}
							
					}
					return $JetzigeAnzahl;
				}
				
				
				/////////////////////////FUNKTION//////////////////////////
				
			
				
				//Durch Freundesliste durchgehen
				
				$date = date("d.m.y");
				
				$Speicherort = "Nachrichten/".$date.".txt";
				
				TestObDa($Speicherort,$date);
				
				
				//Normalwert = 20
				$NachrichtenAnzahl = 20;
				
				if (isset($_POST["nachrichtenAnzahl"])) {
					$NachrichtenAnzahl = $_POST["nachrichtenAnzahl"];
				}
				
				$JetzigeAnzahl = 0;

				$JetzigeAnzahl = KommentareAuslesen($Speicherort,$JetzigeAnzahl,$NachrichtenAnzahl);
				$counter = 0;
				While ($JetzigeAnzahl < $NachrichtenAnzahl and $counter < 20) {
					$date = OutOfTime($date);
					$Speicherort = "Nachrichten/".$date.".txt";
					TestObDa($Speicherort,$date);
					$JetzigeAnzahl = KommentareAuslesen($Speicherort,$JetzigeAnzahl,$NachrichtenAnzahl);
					$counter++;
				}
				
				
				//MEHR KOMMENTARE ANZEIGEN
				echo '
					<div class="mehrKommentareLaden">
						<br>
						<center>
						<a class="mehrKommentareLaden" href="http://localhost/test/facebook/Homepage.php?email=Pascal.Mueller98@gmx.net&nachrichtenAnzahl='.($NachrichtenAnzahl+20).'" >Mehr Kommentare laden</a>
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
			</div>
		
			<div class="textbox" style="height:500px">
				<?php
				echo '
				<form action="KommentarSchreiben.php" class="button">
					<input type="text" name="email" value="'.$_POST["email"].'" style="visibility:hidden"> 
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
					//document.getElementById(nummer.toString().concat("kommentarAdden")).style.margin-top='0';
					document.getElementById(nummer.toString().concat("kommentarAdden")).style.visibility='visible';
				
				
					document.getElementById(nummer.toString().concat("filler")).style.marginBottom='0';
				
					
					//document.getElementById((nummer+1).toString().concat("text")).style.marginTop='5px';
				
					
					
					
				} else {
					document.getElementById(nummer.toString().concat("antwort")).onclick= function(){
																								antworten(nummer,true);
																								return(false);
																							};
					document.getElementById(nummer.toString().concat("kommentarAdden")).style.display='none';
					document.getElementById(nummer.toString().concat("kommentarAdden")).style.visibility='hidden';
					
					document.getElementById(nummer.toString().concat("filler")).style.marginBottom='-15px';

				}
				
				document.getElementById("sidebar").style['height']=document.getElementById("linkeSeite").clientHeight+"px";	
				document.getElementById("rechteSeite").style['height']=document.getElementById("linkeSeite").clientHeight+"px";
			}
			
			
				document.getElementById("sidebar").style['height']=document.getElementById("linkeSeite").clientHeight+"px";	
				document.getElementById("rechteSeite").style['height']=document.getElementById("linkeSeite").clientHeight+"px";
				//alert(document.getElementById("linkeSeite").clientHeight);
			
		</script>
		
	</body>
</html>

