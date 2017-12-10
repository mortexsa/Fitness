<?php

session_start();

if(!empty($_POST['email']) && !empty($_POST['password'])){
	$email = htmlspecialchars(strip_tags(($_POST['email'])));
	//a revoir
	$password = $_POST['password'];


	if(filter_var(variable))
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=fitness;charset=utf8', 'root', '159753Ena,;:');
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
}
else{
	$_SESSION['error'] = "erreur"
}

?>