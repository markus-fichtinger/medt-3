<!DOCTYPE html>
<html>
<head>
	<title>Aufgabenstellung 6.2</title>

	<style>
		nav a {
			margin-left: 5px;
		}

		.data input {
			margin-top: 3.5px;
			margin-bottom: 3.5px;
		}

		a {
			text-decoration: none;
			color: black;
		}

	</style>
</head>
<body>
<wrapper>

	<nav>

	<?php
	$Navigation = ["Home", "About", "Portfolio", "Kontakt", "Login"];

	foreach ($Navigation as $key) { ?>
		<a href="#"> <?php echo "$key"; ?> </a>
		|
		<?php } ?>
</nav>


	<h3 style="color: red;"><u>Kontakt</u></h3>
	<h3 style="color: blue;">Wir freuen uns auf Ihre Anfrage!</h3>

	<p>Der Grund für Ihre Anfrage</p>
	<input type="radio" name="reason" value="fs">Freie Stellen<br>
	<input type="radio" name="reason" value="pr">Produktreklamation<br>
	<input type="radio" name="reason" value="pn">Produktneuheiten<br><br>

	Anrede* 
	<input type="radio" name="geschlecht" value="frau" required>Frau 
	<input type="radio" name="geschlecht" value="herr" required>Herr<br><br>

	Vorname* 
	<input type="text" name="vn" required>
	Nachname* 
	<input type="text" name="nn" required>

	<br><br>

	<div class="data">
		Straße:
		<input type="text" name="straße"><br>
		Postleitzahl:
		<input type="text" name="plz"><br>
		Ort:
		<input type="text" name="ort"><br>
		Land:    
		<input type="text" name="land"><br>
		Telefonnummer:
		<input type="text" name="telefonnummer"><br>
		E-Mail:    
		<input type="email" name="email"><br>
		Anfrage:
		<textarea name="textarea"></textarea>
	</div> <br><br>

	<input type="submit" name="submitBtn" value="Anfrage senden">

</wrapper>
</body>
</html>