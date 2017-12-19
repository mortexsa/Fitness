<?php
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=fitness;charset=utf8', 'utilisateur', 'motdepasse');
	}
	catch(Exception $e) {
	    die('Erreur : '.$e->getMessage());
	}
?>