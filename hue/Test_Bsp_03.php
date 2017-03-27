<!DOCTYPE html>
<html>
<head>
	<title>Formularberarbeitung</title>
	<meta charstet="UTF-8">
</head>
<body>

	<p>Die gewünschten Urlaubstage bitte auswählen:</p>

	<?php
	echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=post>";
	?>

	<input type="checkbox" name="vacation[]" value="mo">Montag<br>
	<input type="checkbox" name="vacation[]" value="di">Dienstag<br>
	<input type="checkbox" name="vacation[]" value="mi">Mittwoch<br>
	<input type="checkbox" name="vacation[]" value="do">Donnerstag<br>
	<input type="checkbox" name="vacation[]" value="fr">Freitag<br><br>

	<input type="submit" name="requestVacationtn" value="Abschicken">

	<?php
	echo "</form>";

	if(isset($_POST['requestVacationtn']))
	{
		$holiday = $_POST['vacation'];
		if(in_array('fr', $holiday))
			echo "<br><p>SIE KÖNENN SICH AM FREITAG KEINEN URLAUB NEHMEN!</p>";

		else
		{
			echo "<h3>Ihre Urlaubstage: </h3>";
			?><ul><?php
			foreach ($holiday as $item)
			{
				echo "<li>".$item."</li>";
			}
			?></ul><?php
		}
		
	}


	?>

</body>
</html>