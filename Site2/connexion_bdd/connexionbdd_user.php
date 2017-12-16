<?php
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=fitness;charset=utf8', 'root', '159753Ena,;:');
	}
	catch(Exception $e) {
	    die('Erreur : '.$e->getMessage());
	}
?>