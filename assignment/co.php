<?php
	include "/opt/hpws22/apache/htdocs/adodb5/tohtml.inc.php";
	include "/opt/hpws22/apache/htdocs/adodb5/adodb.inc.php";
?>


<html>
<head>
<title> Intikken en uitvoeren van een query </title>
</head>
<body>
<?php

	function db_connect()
	{
		$dbdriver = 'oci8'; 	# eg 'oci' or 'postgres'
		$user = 'e300';
		$password = 'e300';
   		$cc = "(DESCRIPTION=(ADDRESS = (PROTOCOL = TCP)(HOST = laurel.local.thomasmore.be)(PORT = 1521))(CONNECT_DATA=(SID=erp)))" ;
		$db = ADONewConnection($dbdriver);
		$db->debug = false;
		$db->disableBlobs = true;
		$db->Connect($cc, $user, $password);
		return $db; 
	}

	$db = db_connect();
	$query = "select sysdate from dual";
	$rs = $db->Execute( $query );
	if (!$rs)
		print $db->ErrorMsg();
	else
	{
			$n = $rs->RowCount();
			$m = $rs->FieldCount();
			echo "Het resultaat bevat $n rijen en $m kolommen ";
			echo "<br /><br />";
			echo "vandaag zijn we :" . $rs->fields[0];
	}


	$db->Close();
 ?>
</body>
</html>

