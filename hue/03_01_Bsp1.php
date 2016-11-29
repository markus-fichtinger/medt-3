<!DOCTYPE html>
<html>
<head>
	<title>MEDT - Beispieil 1</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="C:\Users\Markus\Downloads\bootstrap-3.3.7-dist\css\bootstrap.min.css">

	<style>

  		li:nth-of-type(odd) {
  			background-color: #D8D8D8;
  		}

  		li:nth-of-type(even) {
  			background-color: #FAFAFA;
  		}

  		ul {
  			list-style-type: square;
  		}

  	</style>

</head>
<body>

	<div class="container">
	<h1>Beispiel 1</h1>

	<form method="post">

	Ihre Eingabe:
	<input type="text" name="txt" value="Das ist ein Demo-Satz">

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

	</div>

</body>
</html>