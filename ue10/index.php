<?php
	session_start();

	if (isset($_SESSION['check']))
	{
		header('Location: http://localhost/medt/ue10/project-list.php');
	}	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Uebung 8 - Datenbank</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body class="container">

	<h1>Herzlich Willkommen!</h1> <br>


	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

	
	<label>Benutzername:</label> <input type="text" name="bn" />  <br>
	
	<label>Passwort:</label> <input type="password" name="pw" />  <br><br>

	<input type="submit" name="submitBtn" value="Login" />

	</form>

<?php
	if (isset($_POST['submitBtn']) && $_POST['bn'] == 'markus' && $_POST['pw'] == 'markus')
	{
		session_start();
		$_SESSION['check'] = true;
		header('Location: http://localhost/medt/ue10/project-list.php');
	}
?>

</body>
</html>