<?php
//On lance la session
session_start();

//On verifie que le formulaire a bien été envoyer
if(isset($_POST['submit'])) {
 	if(    !empty($_POST['nom']) 
 		&& !empty($_POST['prenom']) 
 		&& !empty($_POST['inscri_email']) 
 		&& !empty($_POST['date_naissance']) 
 		&& !empty($_POST['tel']) 
 		&& !empty($_POST['sexe']) 
 		&& !empty($_POST['inscri_password']) 
 		&& !empty($_POST['inscri_password2']))
 	{
 		//connexion a la base de données
		include("../connexion_bdd/connexionbdd_user.php");
		
 		extract($_POST);
 		$nom = ucfirst(strtolower(htmlspecialchars(strip_tags($nom))));

		
		//on verifie le nom
 		if(preg_match("#^[\p{L}]{2,20}(\-[\p{L}]{2,20}){0,1}$#",$nom)) {
 			$prenom = ucfirst(strtolower(htmlspecialchars(strip_tags($prenom))));
 			
 			//On vérifie le prenom
 			if(preg_match("#^[\p{L}]{2,20}(\-[\p{L}]{2,20}){0,1}$#",$prenom)){
 				$inscri_email = htmlspecialchars(strip_tags($inscri_email));
 				
 				//On vérifie l'adresse email
 				if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $inscri_email) && strlen($email)<=255) {
 					$date_naissance = htmlspecialchars(strip_tags($date_naissance));
 					
 					//On verifie le format de la date
 					if (preg_match("#^([0-9]{2})/([0-9]{2})/([0-9]{4})$#", $date_naissance)) {
 						$tab = array_map('intval', explode('/', $date_naissance)); 
 						$anne_actuel = intval(date('Y'));
 						
 						//On vérifie si l'utilisateur a 8ans ou plus
 						if(($tab[2]<=($anne_actuel-8)) && ($tab[2]>=($anne_actuel-90))){
 							$tel = htmlspecialchars(strip_tags($tel));
 							
 							//On verifie le numero de telephone
 							if(preg_match("#^0[1-9]{1}[0-9]{8}$#", $tel)){
 								$sexe = htmlspecialchars(strip_tags($sexe));
 								
 								if(($sexe == "H") || ($sexe == "F")){
 									
 									if(strlen($inscri_password)>7 && strlen($inscri_password)<77){
	 									$inscri_password = sha1($inscri_password);
	 									$inscri_password2 = sha1($inscri_password2);
	 									
	 									//On verifie si les mot de passe sont egaux
	 									if($inscri_password == $inscri_password2){
	 										//on verifie si l'email n'ai pas deja present dans la bdd
	 										$req2 = $bdd->prepare("SELECT email FROM utilisateurs WHERE email = ?");
											$req2->execute(array($inscri_email));
											$exist_email = $req2->rowCount();
											//On verifie si le tel n'ai pas present dans la bdd
	 										$req3 = $bdd->prepare("SELECT tel FROM utilisateurs WHERE tel = ?");
											$req3->execute(array($tel));
											$exist_tel = $req3->rowCount();
	 										$req2->closeCursor();
	 										$req3->closeCursor();
	 										if($exist_email) {
	 											$_SESSION['erreur_inscription'] = "Cette adresse e-mail est déja utiliser";
	 										}
	 										elseif($exist_tel) {
	 											$_SESSION['erreur_inscription'] = "Ce numéro de téléphone est déja utiliser";
	 										}
	 										else {
	 											$date_naissance = $tab[2]."-".$tab[1]."-".$tab[0];
	 											$insertuser = $bdd->prepare("INSERT INTO utilisateurs(nom, prenom, email, date_naissance, tel, sexe, password) VALUES(?,?,?,?,?,?,?)");
	 											$insertuser->execute(array($nom, $prenom, $inscri_email, $date_naissance, $tel, $sexe, $inscri_password));
	 											$insertuser->closeCursor();
	 											$user = $bdd->prepare("SELECT id FROM utilisateurs WHERE email=?");
	 											$user->execute(array($inscri_email));
	 											$aff = $user->fetch();
	 											$_SESSION['id'] = $aff['id'];
												header("Location: ../utilisateurs/workouts.php");
	 										}
	 									}
	 									else {
	 										$_SESSION['erreur_inscription'] = "Veuillez entrez des mot de passe identiques";
	 									}
	 								}
	 								else {
	 									$_SESSION['erreur_inscription'] = "Entrez un Mot de passe compris entre 8 et 76 caractères";
	 								}
 								}
 								else {
 									$_SESSION['erreur_inscription'] = "Reste tranquille petit malin ;)";
 								}
 							}
 							else {
 								$_SESSION['erreur_inscription'] = "Le numéro de téléphone est incorrect";
 							}
 						}
 						elseif($tab[2]>=$anne_actuel){
 							$_SESSION['erreur_inscription'] = "La date de naissance est incorrect";
 						}
 						else {
 							$_SESSION['erreur_inscription'] = "L'age limite pour s'inscrire est de 8ans";
 						}
 					}
 					else {
 						$_SESSION['erreur_inscription'] = "Le format de la date est incorrect";
 					}
 				}
 				else {
 					$_SESSION['erreur_inscription'] = "Votre Adresse e-mail est incorrect";
 				}
 			}
 			else {
 				$_SESSION['erreur_inscription'] = "Le format du prénom est incorrect";
 			}
 		}
 		else {
 			$_SESSION['erreur_inscription'] = "Le format du nom est incorrect";
 		}
 	}
 	else {
		$_SESSION['erreur_inscription'] = "Tous les champs sont obligatoires";
	}
	header("Location: ../inscription.php");
}
?>