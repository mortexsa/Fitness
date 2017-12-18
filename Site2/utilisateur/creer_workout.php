<?php 
session_start();
//On vérifie si le get est bon 
if(isset($_SESSION['id'])){
	if(isset($_POST['submit'])) {
		if(!empty($_POST['nom_prog']) && !empty($_POST['commentaire_prog'])){
			include("../connexion_bdd/connexionbdd_user.php");
			extract($_POST);
 			$nom = ucfirst(strtolower(htmlspecialchars(strip_tags($nom_prog))));
 			if(preg_match("#^[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s]{3,200}$#",$nom)) {
 				$commentaire = ucfirst(strtolower(htmlspecialchars(strip_tags($commentaire_prog))));
 				if(preg_match("#^[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s]{3,200}$#", $commentaire)){
 					$insertuser = $bdd->prepare("INSERT INTO programmes(nom, commentaire, date_creation, id_utilisateur) VALUES(?,?,?,?)");
					$insertuser->execute(array($nom, $commentaire, date("Y-m-d H:i:s"), $_SESSION['id']));
					$insertuser->closeCursor();
					header('Location: workout_detail.php');
 				}
 				else {
 					$erreur_inscription = "Le format du commentaire est incorrect";
 				}
 			}
 			else {
 				$erreur_inscription = "Le format du nom est incorrect";
 			}
		}
		else {
			$erreur_inscription = "Tous les champs sont obligatoires";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../style/menu.css">
	<link rel="stylesheet" type="text/css" href="../style/contenu_workout_detail.css">
	<link rel="stylesheet" type="text/css" href="../style/footer.css">
	<link rel="stylesheet" type="text/css" href="../style/creer_workout.css">
	<title>Creer-Workout</title>
	<meta charset="utf-8">
</head>
<body>
	<?php include("menu.php"); ?>
	<div id="conteneur">
		<section>
			<h2>Vous pouvez désormé créer votre workout</h2>
			<h5>Je vous pris de completer tous les champs, ceci est obligatoire<h5>
			<?php
			if(isset($erreur_inscription) AND !empty($erreur_inscription)) {
			echo '<div id="affiche_erreur"><p>'.$erreur_inscription.'</p></div>';
			}
			?>
			<form method="post" action="">
				<p><input type="text" name="nom_prog" id="colone_remplire" placeholder="Nom du Workout"><p>
				<p><textarea style="font-size: 1.5em;" name="commentaire_prog" id="colone_remplire" placeholder="Ajouter un court commentaire"></textarea><p>
				<p><input type="submit" name="submit" value="Creer mon workout" id="submit"><p>
			</form>
			<p><a href="workouts.php">Retourner à mes workouts</a>
		</section>
	</div>
	<?php include("footer.php"); ?>
</body>
</html>
<?php	
}
else {
	header('Location: ../index.php');
}	
?>