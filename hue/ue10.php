<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Uebung 8 - Datenbank</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.2.1.min.js"
  	integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
 	crossorigin="anonymous"> </script>

 	<script>

		$(document).ready(function() {
			//$("#msgBox").hide(); // Leere "Nachrichten"-Box bereitstellen, wird kontextabhängig befüllt und gestaltet

			$('.editicon').click(adjust);
			$('.deleteicon').click(myFunction);
		});

		function adjust(){
			console.log("Bearbeiten");
		}

		function myFunction(){
				//var currentProId = $(this).parent().parent().attr('id');
                var currentProId = $(this).closest("tr").attr('id');
			if (confirm("Wollen Sie das Projekt wirlich löschen?")){
				// ohne jQ: this.parent().parent().id würde nicht funktionieren!!!
				console.log("ID des zu löschenden Projektes: " + currentProId); // jQuery - Variante

				//AJAX-Call konfigurieren
				var myAjaxConfigObj={
					url: "http://localhost/medt/ue10/", // Default: The current page (http://127.0.0.1/medt/ue10/index.php)

					type: "post",

					data: "projectToDelete=" + currentProId,				// Parameter als String...
					//data : {projectToDelete:currentProId, ..., ...}, 		...oder als Objekt

					success: function(dataFromServer, textStatus, jqXHR){
						console.log("Server response: " + dataFromServer);
						if (dataFromServer){
                            if($('#' + currentProId).length) {
                                $('#' + currentProId).remove();
                                $("#msgBox").text("Löschen erfolgreich!").addClass("bg-success").show(200).delay(2000).hide(200);
                            }
                        }
							// Löschen erfolgreich: Zeile mit der Projekt ID aus
							// der HTML-Tabelle entfernen ($(...).remove) und Meldung mit
							// MsgBox (CSS nicht vergessen)
						else
                            $("#msgBox").text("Löschen nicht erfolgreich der ID ").addClass("bg-danger").show(200).delay(2000).hide(200);
							// Löschen nicht erfolgreich: MsgBox mit Fehlermeldung
							// (CSS nicht vergessen)
					},

					// Ist das Ziel, wenn die HTTP-Response nicht vom Statuscode 200 ist
					error: function(jqXHR, msg){
						console.log("Server response: " + msg);
						$("#msgBox").text("Server nicht verfügbar!").addClass("bg-danger").show(200).delay(2000).hide(200);
					}

				};


				$.ajax(myAjaxConfigObj);
			}				
				
			else
				console.log("Ohhh, no!" + currentProId); // JavaScript
				
		}

	</script>


</head>
<body>
	<div class="container">

	<?php

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
        $projectId = $_GET['deleteProject'];
        $delete = $db->query("DELETE FROM project where id=$projectId");
    }

	if (isset($_POST['projectToDelete']))

	?>

	<h1>PROJEKTÜBERSICHT</h1>

	<span id="msgBox">Test</span>

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
		echo "<tr id=".$item->id.">";

		?> <td class="col-xs-2,4 col-md-2,4"> <?php
		//echo $item->id;
		echo "".$item->id."";
		echo "</td>";

		?> <td class="col-xs-2,4 col-md-2,4"> <?php
		echo $item->name;
		echo "</td>";

		?> <td class="col-xs-2,4 col-md-2,4"> <?php
		echo $item->description;
		echo "</td>";

		?> <td class="col-xs-2,4 col-md-2,4"> <?php
		echo $item->createDate;
		echo "</td>";

		?> <td class="col-xs-2,4 col-md-2,4"> <?php

		// Mit HTML 5 eigene Attribute möglich; data-xyz // Bsp: data-name

		echo "
		<span class=\"glyphicon glyphicon-pencil editicon\" aria-hidden=\"true\"></span>

		<a href=\"index.php?deleteProject=$item->id\"> <span class=\"glyphicon glyphicon-trash deleteicon\" aria-hidden=\"true\"></span> </a>
		";

		echo "</td>";

		echo "</tr>";
	}



	?>

	</table>

	</div>
</body>
</html>