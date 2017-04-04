<!DOCTYPE html>
<html>
<head>
	<title>3xHIT_Bsp3-Pagination</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

	<?php

	$host = 'localhost';
	$dbname = 'classicmodels';
	$user = 'root';
	$pwd = '';

	$wievielSeiten = 20;

	try
	{
	if (isset($_GET['AnzahlSeiten']) && $_GET['AnzahlSeiten'] >= 0)
		$count = $_GET['AnzahlSeiten'];

	else
		$count = 0;

	$db = new PDO ("mysql:host=$host;dbname=$dbname", $user, $pwd ); // komfortable Schnittstelle PDO
	$sql = "SELECT productCode, productName, productLine From products limit $count,$wievielSeiten";
	$maxsql = "SELECT (ceiling(count(*)/".$wievielSeiten.")-1)*".$wievielSeiten." maxPage FROM products";
	$max = $db->query($maxsql)->fetchAll(PDO::FETCH_ASSOC)[0]['maxPage'];
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	}
	catch (PDOException $e) {

    exit("<p>Datenbank nicht verfügbar</p>"); // die(); geht auch ==> ident
    $db = null;

	}

	echo "<h1>KUNDENÜBERSICHT</h1>";

	?>
	<p style="text-align:center;">

	

	

	<!--<a href="3xHIT_Bsp3-Pagination.php?AnzahlSeiten=0"> <span class="glyphicon glyphicon-step-backward"></span> </a>-->

	<a href="3xHIT_Bsp3-Pagination.php?AnzahlSeiten=0"> <span class="glyphicon glyphicon-step-backward"></span> </a>

	<a href="3xHIT_Bsp3-Pagination.php?AnzahlSeiten=<?php echo $count-$wievielSeiten < 0 ? 0 : $count-$wievielSeiten; ?>"> <span class="glyphicon glyphicon-chevron-left"></span> </a>

	<a href="3xHIT_Bsp3-Pagination.php?AnzahlSeiten=<?php echo $count+$wievielSeiten > $max ? $max : $count+$wievielSeiten; ?>"> <span class="glyphicon glyphicon-chevron-right"></span> </a>

	<a href="3xHIT_Bsp3-Pagination.php?AnzahlSeiten=<?php echo $max; ?>"> <span class="glyphicon glyphicon-step-forward"></span> </a>


	
	</p>
	<?php

	echo "<table class=\"table tables-bordered\">";

	echo "<thead>";
		echo "<th>productCode</th>";
		echo "<th>productName</th>";
		echo "<th>productLine</th>";
	echo "</thead>";

	foreach ($db->query($sql) as $item)
	{
		echo "<tr>";

		?> <td class="col-xs-4 col-md-4"> <?php
		echo $item->productCode;
		echo "</td>";

		?> <td class="col-xs-4 col-md-4"> <?php
		echo $item->productName;
		echo "</td>";

		?> <td class="col-xs-4 col-md-4"> <?php
		echo $item->productLine;
		echo "</td>";
	}

	echo "</table>";
	?>

	


</body>
</html>