<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Uebung 8 - Datenbank</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

	<?php


	echo $_SERVER['REQUEST_URI'];


	$host = 'localhost';
	$dbname = 'medt3';
	$user = 'htluser';
	$pwd = 'htluser';


	try
	{
	$db = new PDO ("mysql:host=$host;dbname=$dbname", $user, $pwd ); // komfortable Schnittstelle PDO
	$sql = "SELECT * From project";
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	}
	catch (PDOException $e) {

    exit("<p>Datenbank nicht verfügbar</p>"); // die(); geht auch ==> ident
    $db = null;

	}


	


	if (isset($_GET['deleteProject']))
	{
		/*echo "Löschen:  ".$_GET['deleteProject'];*/

		$projectId = $_GET['deleteProject'];
		$delete = $db->query("DELETE FROM project where id=$projectId");
		//$delete -> execute(); //wird nicht benötigt

		$tmp = true; // dynamisch
		if ($tmp)
			echo '<p class="bg-success">Das Projekt wurde erfolgreich gelöscht!</p>';

		else
			echo '<p class="bg-danger">Das Projekt konnte nicht gelöscht werden</p>';
	}



	if (isset($_GET['editProject']) || isset($_POST['editProject']))
	{
		if (isset($_POST['submitButton']))
		{
			$edit = $db->query("UPDATE project SET name=\"".$_POST['Name']." \", description=\"".$_POST['Beschreibung']."\", createDate=\"".$_POST['Datum']."\" WHERE id=".$_POST['editProject']);
			//$edit -> execute(); //wird nicht benötigt
		}
		else {
		$query = $db->query("SELECT * from project where id=".$_GET['editProject']);
		$data = $query -> fetch(PDO::FETCH_OBJ); // eine Zeile kommt zurück

		echo '<form action="#" method="POST" style="margin-top: 50px; margin-bottom: 50px; margin-left: 25%">';
		echo "<input name=\"Name\" type=\"text\" value=\"$data->name\"><br>";
		echo "<input name=\"Beschreibung\" type=\"text\" value=\"$data->description\"><br>";
		echo "<input name=\"Datum\" type=\"date\" value=\"$data->createDate\"><br>";
		echo "<input name=\"editProject\" type=\"text\" value=\"".$_GET['editProject']."\" hidden>";
		echo '<input type="submit" name="submitButton">';
		echo "</form>";
		}
	}


	?>

	<h1>DATENBANK!</h1>

	<table class="table table-striped">
	<thead>
		<th>Project ID</th>
		<th>Project Name</th>
		<th>Project Description</th>
		<th>User ID</th>
		<th>Create Date</th>
		<th></th>
	</thead>

	<?php

	
	

	$i = 1;
	foreach ($db->query($sql) as $item)
	{
		echo "<tr>";

		?> <td class="col-xs-2 col-md-2"> <?php
		echo $item->id;
		echo "</td>";

		?> <td class="col-xs-2 col-md-2"> <?php
		echo $item->name;
		echo "</td>";

		?> <td class="col-xs-2 col-md-2"> <?php
		echo $item->description;
		echo "</td>";

		?> <td class="col-xs-2 col-md-2"> <?php
		echo $item->createDate;
		echo "</td>";

		/*?> <td class="col-xs-2 col-md-2"> <?php
		echo $item->createDate;
		echo "</td>";*/

		?> <td class="col-xs-3 col-md-3"> <?php

		echo "
		<a href=\"index.php?editProject=$item->id\" style=\"margin-right: 15px;\"> <span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span> </a>

		<a href=\"index.php?deleteProject=$item->id\"> <span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span> </a>";

		echo "</td>";

		echo "</tr>";
	}



	?>

	</table>

	<?php

	



	/*$status = $db->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	if($status=true)
	{
		echo "Verbindungsaufbau war erfolgreich!";
		$db = null;
	}*/

		
	

	?>

</body>
</html>