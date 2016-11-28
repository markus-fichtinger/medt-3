<!DOCTYPE html>
<html>
<head>
	<title>MEDT - Beispieil 1</title>
	<meta charset="UTF-8">
</head>
<body>

	<h1>Beispiel 1</h1>

	<form method="post">

	Ihre Eingabe:
	<input type="text" name="txt">

	<br><br>

	<input type="submit" name="exploreBtn" value="Explode">
	<input type="submit" name="resetBtn" value="Reset">

	<form method="post">



	<?php

	if(isset($_POST['exploreBtn'])) {

	$text = $_POST['txt'];
	$arr = explode(" ", $text);

		echo "<br>"; echo "<br>"; echo "<br>";

		echo "Ihre Eingabe als Liste";

		echo "<ul>";
		foreach ($arr as $item) {
			echo "<li>$item</li>";
		}
		echo "</ul>";
	}

	?>

</body>
</html>