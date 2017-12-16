<?php
//On lance la session
session_start();
//connexion a la base de données
include('../connexion_bdd/connexionbdd_user.php');
//on teste si le formulaire est bien remplie
if(isset($_POST)){
 	if(!empty($_POST['email']) && !empty($_POST['password'])){
		
		//on extrait et on sécurise les variable.
		extract($_POST);
		$email = htmlspecialchars(addslashes($email));
		$password = sha1($password);
		
		//requete preparer pour verifier si l'email et le mot de passe sont bon
		$req = $bdd->prepare("SELECT id FROM utilisateurs WHERE email= ? AND password= ?");
		$req->execute(array($email, $password));
		
		//on verifie que la requete a bien trouver l'utilisateur unique
		if($req->rowCount() == 1){
			$userinfo = $req->fetch();
			$_SESSION['id'] = $userinfo['id'];
			header("Location: ../utilisateur/accueil.php");
			exit();
		}
		else
		{
			$_SESSION['erreur'] = "Vos identifiants sont incorrects";
		}
	}
	else{
		$_SESSION['erreur'] = "Tous les champs sont obligatoires";
	}
	header("Location: ../index.php");
}

?>