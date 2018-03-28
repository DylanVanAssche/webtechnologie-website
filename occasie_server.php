<?php
	// DB module
	include "/opt/hpws22/apache/htdocs/adodb5/tohtml.inc.php";
	include "/opt/hpws22/apache/htdocs/adodb5/adodb.inc.php";

	if($_GET["data"] == "model") {
		get_modellen($_GET["merk"]); // from model
	}
	else if($_GET["data"] == "lijst") {
		get_lijst($_GET["model"], $_GET["merk"]); // from occasie
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
	
	function get_modellen($merk) {
		$db = db_connect();
		$query = "SELECT DISTINCT model FROM occasies WHERE merk=" . $db->qStr($merk);
		$rs = $db->Execute($query);
		if (!$rs)
			print $db->ErrorMsg();
		else
		{
				// p60
				echo "<option disabled selected value> -- selecteer model -- </option>";
				while(!$rs->EOF) {
					echo "<option value=" . $rs->fields[0] . ">" . $rs->fields[0] . "</option>";
					$rs->MoveNext();
				}
		}
		$db->Close();	
	}
	
	function get_lijst($model, $merk) {
		$db = db_connect();
		$query = "SELECT nr, merk, model, jaartal, km, prijs FROM occasies WHERE merk=" . $db->qStr($merk) . " AND model=" . $db->qStr($model);
		$rs = $db->Execute($query);
		if (!$rs)
			print $db->ErrorMsg();
		else
		{
				// p60
				echo "<tr>";
				echo "<th>Stock nummer</th>";
				echo "<th>Merk</th>";
				echo "<th>Model</th>";
				echo "<th>Jaartal</th>";
				echo "<th>KM</th>";
				echo "<th>Prijs (&euro;)</th>";
				echo "</tr>";

				while(!$rs->EOF) {
					echo "<tr>";
					echo "<td>" . $rs->fields[0] . "</td>";
					echo "<td>" . $rs->fields[1] . "</td>";
					echo "<td>" . $rs->fields[2] . "</td>";
					echo "<td>" . $rs->fields[3] . "</td>";
					echo "<td>" . $rs->fields[4] . "</td>";
					echo "<td>" . $rs->fields[5] . "</td>";
					echo "</tr>";
					$rs->MoveNext();
				}
		}
		$db->Close();		
	}
?>
