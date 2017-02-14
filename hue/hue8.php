<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Uebung 8 - Datenbank</title>
</head>
<body>

	<?php

try
{

	$host = 'localhost';
	$dbname = 'medt3';
	$user = 'htluser';
	$pwd = 'htluser';


	$db = new PDO ( "mysql:host=$host;dbname=$dbname", $user, $pwd );
	$sql = "SELECT * From htl";


	foreach ($db->query($sql) as $row)
	{
		//print_r($row);
		echo $row['Klasse'];
		echo " ";
		echo $row['Schueler'];
		echo "<br>";
	}
	echo "<br>";

}

catch (PDOException $e) {
    echo 'Verbindung fehlgeschlagen: ' . $e->getMessage();
    $db = null;
    die();
}

	$status = $db->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	if($status=true)
	{
		echo "Verbindungsaufbau war erfolgreich!";
		$db = null;
	}
	

	?>

</body>
</html>