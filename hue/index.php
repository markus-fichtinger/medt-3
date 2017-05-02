<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Uebung 8 - Datenbank</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
	<div class="container">

	<?php


	#echo $_SERVER['REQUEST_URI'];
	#echo "<br>";


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
		$projectIdDelete = $_GET['deleteProject'];
		//$delete = $db->query("DELETE FROM project where id=$projectId");

		$query = $db->prepare('DELETE FROM project WHERE id= :projectIdDelete');
		$query->bindParam(':projectIdDelete', $_GET['deleteProject'], PDO::PARAM_INT);
		$query->execute();
		
		$count = $query->rowCount();

		//$count = $delete->rowCount();

		if ($count == 1)
			echo '<p class="bg-success">Das Projekt wurde erfolgreich gelöscht!</p>';

		else
			echo '<p class="bg-danger">Das Projekt konnte nicht gelöscht werden</p>';
	}



	if (isset($_GET['editProject']) || isset($_POST['editProject']))
	{
		if (isset($_POST['submitButton']))
		{
			$projectIdEdit = $_POST['editProject'];
			$query2 = $db->prepare("UPDATE project SET name=:nam,description=:desc,createDate=:Date WHERE id=:projectIdEdit");
			$query2->bindParam(':nam', $_POST['Name'], PDO::PARAM_STR);
			$query2->bindParam(':desc', $_POST['Beschreibung'], PDO::PARAM_STR);
			$query2->bindParam(':Date', $_POST['Datum']);
			$query2->bindParam(':projectIdEdit', $projectIdEdit, PDO::PARAM_INT);
			$query2->execute();

			$countEdit = $query2->rowCount();

			//$edit = $db->query("UPDATE project SET name=\"".$_POST['Name']."\", description=\"".$_POST['Beschreibung']."\", createDate=\"".$_POST['Datum']."\" WHERE id=\"".$_POST['editProject']."\"");
			//$edit -> execute(); //wird nicht benötigt

		//$countEdit = $edit->rowCount(); //Anzahl der Zeilen die bearbeitet wurden

		if ($countEdit == 1)
			echo "<p class=\"bg-success\">Das Projekt wurde erfolgreich bearbeitet!</p>";

		else
			echo "<p class=\"bg-danger\">Das Projekt konnte nicht bearbeitet werden</p>";

		
}		else {
		$query = $db->query("SELECT * from project where id=".$_GET['editProject']);	
		$data = $query -> fetch(); // eine Zeile kommt echo

		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" style=\"margin-top: 50px; margin-bottom: 50px; margin-left: 25%\">";
		echo "<input name=\"Name\" type=\"text\" value=\"$data->name\"><br>";
		echo "<input name=\"Beschreibung\" type=\"text\" value=\"$data->description\"><br>";
		echo "<input name=\"Datum\" type=\"date\" value=\"$data->createDate\"><br>";
		echo "<input name=\"editProject\" type=\"text\" value=\"".$_GET['editProject']."\" hidden>";
		echo "<input type=\"submit\" name=\"submitButton\">";
		echo "</form>";
		}
	}


	?>


	<h1>PROJEKTÜBERSICHT!</h1>
	<hr>

	<?php echo "<a href=\"index.php?createProject\" class=\"btn btn-primary\" role=\"button\"><span class=\"glyphicon glyphicon-tasks\"></span> Neues Projekt erstellen</a>";

	if (isset($_GET['createProject']) || isset($_POST['createProject']))
	{

		if (isset($_POST['createProject'])) 
		{
			$query = $db->prepare("INSERT into project (name,description,createDate) VALUES (:name,:description,:createDate)");
			$query->bindParam(':name',$_POST['name'],PDO::PARAM_STR);
			$query->bindParam(':description',$_POST['desc'],PDO::PARAM_STR);
			$query->bindParam(':createDate',$_POST['createDate']);
			$query->execute();

			$rowCount = $query->rowCount();
		}

		else {
		echo "<h4><b>Neues Projekt</b></h4>";

		echo '<h4><span class="glyphicon glyphicon-tasks"></span>';
			echo "Sie erstellen ein neues Projekt.</h4>";
				echo "<form action=\"index.php\" method=\"POST\">";
					echo '<div class="form-group">';
					echo "<label>Name <input class=\"form-control\" type=\"text\" name=\"name\" required></label><br>";
					echo "<label>Description <input class=\"form-control\" type=\"text\" name=\"desc\"></label><br>";
					echo "<label>Create Date <input class=\"form-control\" type=\"date\" name=\"createDate\"></label><br>";
					echo '<br><input style="margin-right:20px;" type="submit" name="createProject">';
					echo "<input name=\"createProject\" value=\"".$_GET['createProject']."\" hidden>";
					echo '<a href="index.php"><span style="margin-right:5px;" class="glyphicon glyphicon-remove"></span>Abbrechen</a>';
					echo '</div>';
				echo "</form><br>";
	}

	}

	?>

	<br><br>
	<table class="table table-striped">
	<thead>
		<th>Project ID</th>
		<th>Project Name</th>
		<th>Project Description</th>
		<th>User ID</th>
		<th>Create Date</th>
	</thead>


	<?php

	foreach ($db->query($sql) as $item)
	{
		echo "<tr>";

		?> <td class="col-xs-2,4 col-md-2,4" style="<?php echo $STYLE; ?>"> <?php
		//echo $item->id;
		echo "".$item->id."";
		echo "</td>";

		?> <td class="col-xs-2,4 col-md-2,4" style="<?php echo $STYLE; ?>"> <?php
		echo $item->name;
		echo "</td>";

		?> <td class="col-xs-2,4 col-md-2,4" style="<?php echo $STYLE; ?>"> <?php
		echo $item->description;
		echo "</td>";

		?> <td class="col-xs-2,4 col-md-2,4" style="<?php echo $STYLE; ?>"> <?php
		echo $item->createDate;
		echo "</td>";

		/*?> <td class="col-xs-2 col-md-2"> <?php
		echo $item->createDate;
		echo "</td>";*/

		?> <td class="col-xs-2,4 col-md-2,4"> <?php

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

	</div>
</body>
</html>