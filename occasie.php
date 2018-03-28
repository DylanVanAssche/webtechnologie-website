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
		
		<script>
		var http = new XMLHttpRequest();
		var model = "";
		var merk = "";
		
		function processMerk() {
			console.log("Model ophalen");
			var merk_select = document.getElementById("merk-select");
			merk = merk_select.options[merk_select.selectedIndex].text;
			document.getElementById("merk-div").innerHTML = "";
			http.open("GET", "occasie_server.php?data=model&merk=" + merk);
			http.onreadystatechange = parseMerk;
			http.send(null);
		}
		
		function processModel() {
			console.log("Lijst ophalen");
			var model_select = document.getElementById("model-select");
			model = model_select.options[model_select.selectedIndex].text;
			document.getElementById("model-div").innerHTML = "";
			console.log("occasie_server.php?data=lijst&merk=" + merk + "&model=" + model);
			http.open("GET", "occasie_server.php?data=lijst&merk=" + merk + "&model=" + model);
			http.onreadystatechange = parseModel;
			http.send(null);
		}
		
		function parseMerk() {
			if (http.readyState == 4) {
				var text = http.responseText;
				console.log("Ontvangen via AJAX: " + text);
				text = '<select name="model" id="model-select" onchange="processModel();">' + text + '</select>';
				document.getElementById("model-div").innerHTML = text;
			}
		}
		
		function parseModel() {
			if (http.readyState == 4) {
				var text = http.responseText;
				console.log("Ontvangen via AJAX: " + text);
				text = '<table id="lijst-table">' + text + '</table>';
				document.getElementById("lijst-div").innerHTML = text;
			}
		}
		</script>
		<section>
		<h1>Occassies</h1>
		<p>Doorzoek ons uitgebreid occasiepark:</p>
		<p>
			<form>
				<!--Merk selecteren-->
				<div id="merk-div">
					<select name="merk" id="merk-select" onchange="processMerk();">
						<option disabled selected value> -- selecteer merk -- </option>
						<?php
							// DB module
							include "/opt/hpws22/apache/htdocs/adodb5/tohtml.inc.php";
							include "/opt/hpws22/apache/htdocs/adodb5/adodb.inc.php";
							
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

							$db = db_connect();
							$query = "SELECT DISTINCT merk FROM occasies";
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
				</div>
				
				<!--Model selecteren-->
				<div id="model-div">
				</div>
				
				<!--Occassielijst-->
				<div id="lijst-div">
				</div>
			</form>
		</p>
		</section>
		<!--Footer-->
		<?php include("footer.php")?>
	</body>
</html>