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

?>