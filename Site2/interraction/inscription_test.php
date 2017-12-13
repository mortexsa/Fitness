<?php
//On lance la session
session_start();
//connexion a la base de données
try {
	$bdd = new PDO('mysql:host=localhost;dbname=fitness;charset=utf8', 'root', '159753Ena,;:');
}
catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}

if(isset($_POST)) {
 	if(    !empty($_POST['nom']) 
 		&& !empty($_POST['prenom']) 
 		&& !empty($_POST['inscri_email']) 
 		&& !empty($_POST['date_naissance']) 
 		&& !empty($_POST['tel']) 
 		&& !empty($_POST['sexe']) 
 		&& !empty($_POST['inscri_password']) 
 		&& !empty($_POST['inscri_password2'])) {

 		echo "c'est bon";
 	}
 	else {
 		echo "c'est pas bon du tout";
 	}
}
?>