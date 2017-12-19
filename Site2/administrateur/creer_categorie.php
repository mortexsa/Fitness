<?php 

include("connexionbdd_admin.php");
if(isset($_POST['submit']) && !empty($_POST['submit'])){
	if(!empty($_POST['nom'])){
		extract($_POST);
		$nom = ucfirst(strtolower(htmlspecialchars(strip_tags($nom))));
		if(preg_match("#^[\p{L}]{3,20}$#", $nom)){
			$req2 = $bdd->prepare("SELECT muscle_cibler FROM categories WHERE muscle_cibler = ?");
			$req2->execute(array($nom));
			$nom_exist = $req2->rowCount();
			if($nom_exist){
				$erreur = "Cette exercice existe dèja";
			}else {
				$insertcat = $bdd->prepare("INSERT INTO categories(muscle_cibler) VALUES(?)");				
				$insertcat->execute(array($nom));
				$insertcat->closeCursor();
				$erreur = "Ajout fait avec succes";
			}
		}
		else{
			$erreur = "Le nom doit contenir entre 3 et 20 caractères";
		}
	}
	else {
		$erreur= "Tous les champs sont obligatoires";
	}
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Administrateur</title>
	<link rel="stylesheet" type="text/css" href="menu.css">
	<link rel="stylesheet" type="text/css" href="../style/footer.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php include("menu_admin.php"); ?>
	<div id="conteneur">
		<section>
			<h3>Creez votre nouvelle catégorie!</h3>
			<?php
			if(isset($erreur) AND !empty($erreur)) {
			echo '<div id="affiche_erreur"><p>'.$erreur.'</p></div>';
			}
			?>
			<br>
			<form method="post" action="">
				<input type="text" name="nom" id="colone_remplire" placeholder="Nom de categorie">
				</br></br>
				<input type="submit" name="submit" id="submit" value="Envoyer">
			</form>
		</section>
	</div>
	<?php include("../utilisateur/footer.php"); ?>
</body>
</html>
