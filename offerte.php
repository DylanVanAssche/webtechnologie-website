<?php
	if(!empty($_POST["naam"])) {
		$verval = mktime(0,0,0,1,1,2042);
		setcookie("naam", $_POST["naam"], $verval);
	}
?>
	
<!DOCTYPE html>
<html lang="nl">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="./js/html5.js"> </script>
	<link href="./css/stylesheet.css" rel="stylesheet" type="text/css">
	<title>DDT ok&eacute; cars</title>
</head>
	<body>
    <!--Header-->
	<?php include("header.php")?>
	
	<!-- Pagina en DB logica -->
	<?php
		// DB module
		include "/opt/hpws22/apache/htdocs/adodb5/tohtml.inc.php";
		include "/opt/hpws22/apache/htdocs/adodb5/adodb.inc.php";
	
		if(empty($_POST["next"]))
		{
			db_connect();
			display_merk();
		}
		elseif($_POST["next"] == "brandstof") {
			display_brandstof();
		}
		elseif($_POST["next"] == "opties") {
			display_opties();
		}
		elseif($_POST["next"] == "overzicht") {
			display_overzicht();
		}
		elseif($_POST["next"] == "bewaar") {
			display_bewaren();
		}
		else {
			display_oops();
		}

		function db_connect()
		{
			$dbdriver = 'oci8'; 	# eg 'oci' or 'postgres'
			$user = 'e300';
			$password = 'e300';
			$cc = "(DESCRIPTION=(ADDRESS = (PROTOCOL = TCP)(HOST = laurel.local.thomasmore.be)(PORT = 1521))(CONNECT_DATA=(SID=erp)))" ;
			$db = ADONewConnection($dbdriver);
			$db->debug = false;
			$db->disableBlobs = false;
			$db->Connect($cc, $user, $password);
			return $db; 
		}
	?>
    <!--Content-->
		<!-- Toon Merk stap -->
		<?php
			function display_merk()
			{
		?>
		<section>
		<h1>Offerte</h1>
		<h2>Merk</h2>
		<p>Selecteer u merk:</p>
		<form action="./offerte.php" method="post">
				<select name="merk">
					<?php
						$db = db_connect();
						$query = "SELECT modelnr, merk, model FROM model";
						$rs = $db->Execute($query);
						if (!$rs)
							print $db->ErrorMsg();
						else
						{
								// p60
								while(!$rs->EOF) {
									echo "<option value=" . $rs->fields[0] . ">" . $rs->fields[1] . " " . $rs->fields[2] . "</option>";
									$rs->MoveNext();
								}
						}
						$db->Close();	
					?>
				</select>
				<input type="hidden" name="next" value="brandstof"/>
				<input type="submit" value="Volgende" />
		</form>
		</section>
		<?php		
			}
		?>
		
		<!-- Toon Brandstof stap -->
		<?php
			function display_brandstof()
			{
		?>
		<section>
		<h1>Offerte</h1>
		<h2>Brandstof</h2>
		<p>Selecteer u brandstof:</p>
		<form action="./offerte.php" method="post">
				<select name="brandstof">
					<?php
						$db = db_connect();
						$query = "SELECT soort FROM model_brandstof WHERE modelnr=" . $_POST["merk"];
						$rs = $db->Execute($query);
						if (!$rs)
							print $db->ErrorMsg();
						else
						{
								// p60
								while(!$rs->EOF) {
									echo "<option value=" . $rs->fields[0] . ">" . $rs->fields[0] . "</option>";
									$rs->MoveNext();
								}
						}
						$db->Close();
					?>
				</select>
				<input type="hidden" name="next" value="opties"/>
				<input type="hidden" name="merk" value="<?php echo $_POST["merk"] ?>" />
				<input type="submit" value="Volgende" />
		</form>
		</section>
		<?php		
			}
		?>
		
		<!-- Toon Opties stap -->
		<?php
			function display_opties()
			{
		?>
		<section>
		<h1>Offerte</h1>
		<h2>Opties</h2>
		<p>Selecteer u extra opties:</p>
		<form action="./offerte.php" method="post">
				<!-- Gebruik opties[] om een PHP array te krijgen -->
				<?php
					$db = db_connect();
					$query = "SELECT optienr, optie, prijs FROM optie WHERE optienr IN (SELECT optienr FROM model_optie WHERE modelnr=" . $_POST["merk"] . ")";
					$rs = $db->Execute($query);
					if (!$rs)
						print $db->ErrorMsg();
					else
					{
							// p60
							while(!$rs->EOF) {
								echo "<input type='checkbox' name='opties[]' value=" . $rs->fields[0] . ">" . $rs->fields[1] . " €" . $rs->fields[2] . "<br>";
								$rs->MoveNext();
							}
					}
					$db->Close();
					?>
				<input type="hidden" name="next" value="overzicht"/>
				<input type="hidden" name="merk" value="<?php echo $_POST["merk"] ?>" />
				<input type="hidden" name="brandstof" value="<?php echo $_POST["brandstof"] ?>" />
				<input type="submit" value="Volgende" />
		</form>
		</section>
		<?php		
			}
		?>
		
		<!-- Toon Overzicht stap -->
		<?php
			function display_overzicht()
			{
		?>
		<section>
		<h1>Offerte</h1>
		<h2>Overzicht</h2>
		<form action="./offerte.php" onsubmit="return validateForm()" method="post" id="overzicht-form">
			<p class="bold">Uw ultieme wagen:</p>
			<p>
				<ul class="hidden-ul">
					<!--TO DO: SQL SELECT van alle data van de fields om overzicht op te bouwen-->
					<li>Merk: 
					<?php
						$prijs = 0;
						$db = db_connect();
						$queryPrijs = "SELECT prijs FROM model_brandstof WHERE soort='" . $_POST["brandstof"] . "' AND modelnr=" . $_POST["merk"];
						$queryModel = "SELECT merk, model FROM model WHERE modelnr=" . $_POST["merk"];
						$rs = $db->Execute($queryModel);
						if (!$rs)
							print $db->ErrorMsg();
						else
						{
								// p60
								while(!$rs->EOF) {
									echo $rs->fields[0] . " " . $rs->fields[1];
									$rs->MoveNext();
								}
						}
						
						$rs = $db->Execute($queryPrijs);
						if (!$rs)
							print $db->ErrorMsg();
						else
						{
								// p60
								while(!$rs->EOF) {
									$prijs = $prijs + intval($rs->fields[0]);
									$rs->MoveNext();
								}
						}
					?>
					</li>
					<li>Brandstof: <?php echo $_POST["brandstof"] ?></li>
					<li>Opties:
					<?php
						if(count($_POST["opties"]) == 0) {
							echo "geen";
						}
						else {
							for($i=0; $i < count($_POST["opties"]); $i++) {
								
								// Print alle gekozen opties
								$queryOpties = "SELECT optie, prijs FROM optie WHERE optienr=" . $_POST["opties"][$i];
								$rs = $db->Execute($queryOpties);
								if (!$rs)
									print $db->ErrorMsg();
								else
								{
										// p60
										while(!$rs->EOF) {
											echo $rs->fields[0];
											$prijs = $prijs + intval($rs->fields[1]);
											$rs->MoveNext();
										}
								}
								
								// Voeg komma's toe aan opsomming opties
								if($i < (count($_POST["opties"]) - 1)) {
									echo ", ";
								}
							}
						}
						
						$db->Close();
					?>
					</li>
					<li>Prijs: <span id="prijskaartje"><?php echo $prijs; ?></span> &euro;
					</li>
				</ul>
				Naam:<br>
				<input type="text" name="naam" value="<?php echo $_COOKIE["naam"] ?>"> <br>
	
				Eerste aankoop?<br>
				<input type="radio" name="eerste-aankoop" value="0" checked onclick="refreshPrijs();">Ja<br>
				<input type="radio" name="eerste-aankoop" value="1" onclick="refreshPrijs();">Nee<br>
				<input type="hidden" name="next" value="bewaar"/>
				<input type="hidden" name="merk" value="<?php echo $_POST["merk"] ?>" />
				<input type="hidden" name="brandstof" value="<?php echo $_POST["brandstof"] ?>" />
				<input type="hidden" name="opties" value="<?php echo implode("-", $_POST["opties"]); ?>" />
				<input type="submit" value="Verzenden">
			</form>
		</p>
		</section>
		<script>
			var form = document.getElementById("overzicht-form");
			console.log(form.elements["eerste-aankoop"].value);
			var oudePrijs = parseInt(document.getElementById("prijskaartje").innerHTML);
			console.log(oudePrijs);
			
			function refreshPrijs() {
				if(parseInt(form.elements["eerste-aankoop"].value)) {
					document.getElementById("prijskaartje").innerHTML = oudePrijs * 0.01;
				}
				else {
					document.getElementById("prijskaartje").innerHTML = oudePrijs;
				}
			}
			
			function validateForm() {
				var name = form["naam"].value;
				if (name == "") {
					alert("Naam is verplicht!");
					return false;
				}
			} 
		</script>
		<?php		
			}
		?>
		
		<!-- Toon Bewaren -->
		<?php
			function display_bewaren()
			{
				$db = db_connect();
				$queryNr = "SELECT MAX(offertenr) FROM offerte";
				$nr = 0;
				$naam = $db->qstr($_POST["naam"]); // toevoegen
				$merk = $_POST["merk"];
				$brandstof = $db->qstr($_POST["brandstof"]);
				$optie = 0;
								
				$rs = $db->Execute($queryNr);
				if (!$rs)
					print $db->ErrorMsg();
				else
				{
						// p60
						while(!$rs->EOF) {
							$nr = intval($rs->fields[0]) + 1;
							$rs->MoveNext();
						}
				}
				
				$queryInsertOfferte = "INSERT INTO offerte (offertenr, klant, datum, modelnr, brandstof) VALUES ($nr, $naam, sysdate, $merk, $brandstof)";
				$db->Execute($queryInsertOfferte);
				
				for($i=0; $i < count($_POST["opties"]); $i++) {
					$optie = explode("-", $_POST["opties"])[$i];
					$queryInsertOptie = "INSERT INTO offerte_optie(offertenr, optienr) VALUES ($nr, $optie)";
					$db->Execute($queryInsertOptie);
				}
				$db->Close();
		?>
		<section>
		<h1>Bedankt!</h1>
		<p>Uw offerte werd opgeslagen.</p>
		</section>
		<?php		
			}
		?>
		
		<!-- Toon Oops -->
		<?php
			function display_oops()
			{
		?>
		<section>
		<h1>Oops!</h1>
		<p>Er is iets misgelopen bij het verwerken van u aanvraag, probeer het opnieuw.</p>
		<form action="./offerte.php" method="post">
				<input type="hidden" name="next" value="merk"/>
				<input type="submit" value="Probeer opnieuw" />
		</form>
		</section>
		<?php		
			}
		?>

    <!--Footer-->
   <?php include("footer.php")?>
  </body>
</html>