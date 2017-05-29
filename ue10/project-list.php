<?php

    $displayDateFormat = '%d.%m.%Y %H:%i';

	if (isset($_POST['logoutBtn']))
		{
			session_start();
			session_unset();
			session_destroy();
			header('Location: http://localhost/medt/ue10/index.php');
		}

	require "api/isLoggedIn.php";

	require "api/db.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<title>Uebung 8 - Datenbank</title>
		<style>.glyphicon {margin-right:20px;}
				.box {font-size:110%;}</style>
		<script
			src="https://code.jquery.com/jquery-3.2.1.min.js"
			integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
			crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
		integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script>
			var id;
			$(document).ready(function() {
				$("#msgbox").hide(); // msgbox verstecken
				$('.editicon').click(editConfirm);
				$('.deleteicon').click(deleteConfirm);

				$("#deleteBtn").click(function() {
					var ajaxConfigObj = {
						url: "api/trackstar.php", //Default: Aktuelle Seite
						dataType: "json",
						type: "get", // type KLEIN SCHREIBEN!!!!!
						data: "deleteParam=" + id,
						// data:{data1:xyz,data2:xyz,...}
						success: function(dataFromServer, textStatus, jqXHR){
							console.log("Server response: "+dataFromServer.delete);
							if (dataFromServer.delete) {								
								$("#"+id).hide(500);
								$("#msgbox").text("Projekt erfolgreich gelöscht").removeClass("alert-danger").addClass("alert-success").show(500).delay(2500).hide(500);
								//Löschen erfolgreich: Zeile aus der Tabelle entfernen (remove oder hide) und Meldung anzeigen (msgbox, css nicht vergessen)
							}
							else {
								$("#msgbox").text("Projekt konnte nicht entfernt werden.").removeClass("alert-success").addClass("alert-danger").show(500).delay(2500).hide(500);
								//Löschen nicht erfolgreich: Meldung mit Fehler anzeigen (msgbox, css nicht vergessen)
							}
						},
						error: function(jqXHR,msg) { //Ziel wenn die HTTP Response nicht vom Status Code 200 ist
							console.log("Error: Server response was "+msg);
							$("#msgbox").text("Kommunikation mit dem Server nicht möglich.").removeClass("alert-success").addClass("alert-danger").show(500).delay(2500).hide(500);
						},
					};
					$.ajax(ajaxConfigObj);
					$("#deleteModal").modal('hide');
				});


				$("#editBtn").click(function() {
					var ajaxConfigObj = {
						url: "api/trackstar.php", //Default: Aktuelle Seite
						dataType: "json",
						type: "get", // type KLEIN SCHREIBEN!!!!!
						data: "editParam="+id+"&name="+$('#recipient-name').val()+"&description="+$('#message-description').val()+"&createDate="+$('#message-date').val(),
                        // data:{data1:xyz,data2:xyz,...}
						success: function(dataFromServer, textStatus, jqXHR){
							console.log("Server response: "+dataFromServer.edit);
							if (dataFromServer.edit) {
								$("#msgbox").text("Projekt erfolgreich editiert").removeClass("alert-danger").addClass("alert-success").show(500).delay(2500).hide(500);

                                $("#" + dataFromServer.id + " > td").eq(0).text(dataFromServer.name);
                                $("#" + dataFromServer.id + " > td").eq(1).text(dataFromServer.description);

                                var d = new Date(dataFromServer.createDate);
                                $("#" + dataFromServer.id + " > td").eq(2).text(
                                    convertTo2Digits(d.getDate()) + "." + convertTo2Digits(d.getMonth() + 1) + "." + d.getFullYear() + " "
                                    + convertTo2Digits(d.getHours()) + ":" + convertTo2Digits(d.getMinutes())
                                );
								
							}
							else {
								$("#msgbox").text("Projekt konnte nicht editiert werden.").removeClass("alert-success").addClass("alert-danger").show(500).delay(2500).hide(500);
								
							}
						},
						error: function(jqXHR,msg) { //Ziel wenn die HTTP Response nicht vom Status Code 200 ist
							console.log("Error: Server response was "+msg);
							$("#msgbox").text("Kommunikation mit dem Server nicht möglich.").removeClass("alert-success").addClass("alert-danger").show(500).delay(2500).hide(500);
						},
					};
					$.ajax(ajaxConfigObj);
					$("#editModal").modal('hide');
				});


                function convertTo2Digits(i) {
                    if (i < 10)
                        return "0" + i;
                    else
                        return "" + i;
                }
				
			});


			
			function editConfirm() {
				//if(confirm("Projekt "+$(this).closest("tr").attr('id')+" bearbeiten?"))
				//	console.log("Bearbeiten");
				id = $(this).closest("tr").attr('id');
				$('#editModal').modal('show');

                var ajaxConfigObj = {
                    url: "api/trackstar.php", //Default: Aktuelle Seite
                    dataType: "json",
                    type: "get", // type KLEIN SCHREIBEN!!!!!
                    data: "getParam=" + id,
                    // data:{data1:xyz,data2:xyz,...}
                    success: function(dataFromServer, textStatus, jqXHR){
                        console.log("Server response: "+dataFromServer.name);

                        $('#recipient-name').val(dataFromServer.name);
                        $('#message-description').val(dataFromServer.description);
                        $('#message-date').val(dataFromServer.createDate);
                    },
                    error: function(jqXHR,msg) { //Ziel wenn die HTTP Response nicht vom Status Code 200 ist
                        console.log("Error: Server response was "+msg);
                        $("#msgbox").text("Kommunikation mit dem Server nicht möglich.").removeClass("alert-success").addClass("alert-danger").show(500).delay(2500).hide(500);
                    },
                };
                $.ajax(ajaxConfigObj);
			}
			
			function deleteConfirm() {
				id = $(this).closest("tr").attr('id');
				$('#deleteModal').modal('show');
			}

		</script>
	</head>
	<body>
		<div class="container">

			<form method="post" style="float: right;">
				<input type="submit" name="logoutBtn" value="Logout">
			</form>
			

				<h2><span class="glyphicon glyphicon-home"></span>Projektübersicht</h2>


				<!--<p id="msgbox" class="box"></p>-->
				<div id="msgbox" class="alert" role="alert"></div>

				<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Projekt löschen</h4>
					  </div>
					  <div class="modal-body">
						<p>Möchten sie das Projekt wirklich entfernen?</p>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
						<button type="button" class="btn btn-primary" id="deleteBtn">Löschen</button>
					  </div>
					</div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->


				<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Projekt editieren</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				        <form>
				          <div class="form-group">
				            <label for="recipient-name" class="form-control-label"> Name: </label>

				            <input type="text" class="form-control" id="recipient-name">

				          </div>
				          <div class="form-group">
				            <label for="message-description" class="form-control-label"> Beschreibung: </label>
				            <input type"text" class="form-control" id="message-description"></input>
				          </div>
				          <div class="form-group">
				            <label for="message-date" class="form-control-label"> Datum: </label>
				            <input type="datetime-local" class="form-control" id="message-date"></input>
				          </div>
				        </form>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
				        <button type="button" class="btn btn-primary" id="editBtn">Speichern</button>
				      </div>
				    </div>
				  </div>
				</div>


				<table class="table table-hover">
				<thead>
					<th>Name</th>
					<th>Description</th>
					<th>Create Date</th>
					<th>Aktion</th>
				</thead>
				<?php
					$query = $db->prepare("SELECT name, description, DATE_FORMAT(createdate,:dateFormat) createdate, id FROM project");
                    $query -> bindParam(':dateFormat',$displayDateFormat,PDO::PARAM_STR);
                    $query -> execute();
					foreach ($query->fetchAll(PDO::FETCH_OBJ) as $item) { //static zugriff in PHP mit '::'!
						echo "<tr id=\"$item->id\">";
							echo "<td class=\"edit\">$item->name</td>";
							echo "<td class=\"edit\">$item->description</td>";
							echo "<td class=\"edit\">$item->createdate</td>";
							echo "<td><span class=\"glyphicon glyphicon-pencil editicon\">    </span><span class=\"glyphicon glyphicon-remove deleteicon\"></span></td>";
						echo "</tr>";
					}
				?>
				</table>
				<br><br>
		</div>
	</body>
</html>