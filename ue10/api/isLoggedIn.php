<?php

session_start();

if (!isset($_SESSION['check']))
{
	header('Location: http://localhost/medt/ue10/index.php');
}		

?>