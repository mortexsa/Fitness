<?php 
session_start();
//On vérifie si le get est bon 
if(isset($_SESSION['id']) AND isset($_GET['idprog'])){
include("../connexion_bdd/connexionbdd_user.php");
	$idprog = htmlspecialchars(addslashes($_GET['idprog']));
	$idprog = intval($idprog);
	$result_programme = $bdd->prepare("SELECT DISTINCT no_programme,nom_programme,no_exercice,nom_exercice,nbr_repetition 
		FROM programmes_utilisateur 
		WHERE no_utilisateur=? AND no_programme=? 
		ORDER BY nom_exercice");
	$result_programme->execute(array($_SESSION['id'],$idprog));
	if($result_programme->rowCount() > 0){
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../style/menu.css">
	<link rel="stylesheet" type="text/css" href="../style/contenu_workout_detail.css">
	<link rel="stylesheet" type="text/css" href="../style/footer.css">
	<title>Workout-details</title>
	<meta charset="utf-8">
</head>
<body>
	<?php include("menu.php"); ?>
	<div id="conteneur">
		<section>
			<div id="boutton_creation">	
				<a href=<?php echo "editer_workout.php?idprog=".$idprog; ?>>Éditer le workout</a>
			</div>
			<h3>Votre Workout</h3>
			<h5>Cliquez sur un Éxercice pour afficher son contenu ou éditer votre Workout!<h5>
			<?php 
				$rows = $result_programme->fetch();
			?>
			<div class="conteneur_programme">
				<table>
					<tr>
						<th id="titre_programme">
							<?php echo $rows["nom_programme"]; ?>
						</th>
					</tr>
					<?php 
					do {
					?>
					<tr id="commentaire_programme">
						<th><?php echo  '<a href="exercice_detail.php?idexo='.$rows["no_exercice"].'">'.'Exo : '.$rows["nom_exercice"].' -> '.$rows["nbr_repetition"].' répétitions'; ?></a></th>
					</tr>
					<?php
					} while($rows = $result_programme->fetch())
					?>
				</table>
			</div>
		</section>
	</div>
	<?php include("footer.php"); ?>
</body>
</html>

<?php
	$result_programme->closeCursor();	
	}
	else {
		$result_programme->closeCursor();
		header('Location: workouts.php');
	}
}
else {
	header('Location: ../index.php');
}	
?>