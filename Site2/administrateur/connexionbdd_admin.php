<?php
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=fitness;charset=utf8', 'admin', 'securitemaximal');
	}
	catch(Exception $e) {
	    die('Erreur : '.$e->getMessage());
	}
?>