<?php 
session_start();
if(isset($_SESSION['id'])){
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../style/menu.css">
	<link rel="stylesheet" type="text/css" href="../style/contenu_workouts.css">
	<link rel="stylesheet" type="text/css" href="../style/footer.css">
	<title>Workouts</title>
	<meta charset="utf-8">
</head>
<body>
	<?php include("menu.php"); ?>
	<div id="conteneur">
		<section>
			<div id="boutton_creation">	
				<a href="creer_workout.php">Créer un workout</a>
			</div>
			<h3>Vos Workouts</h3>
			<h5>Cliquez sur un Workout pour afficher sont contenu ou creez en un nouveau!<h5>
			<?php 
			include("../connexion_bdd/connexionbdd_user.php");
			$result_programme = $bdd->prepare("SELECT DISTINCT no_programme,nom_programme,commentaire FROM programmes_utilisateur WHERE no_utilisateur=? ORDER BY no_programme");
			$result_programme->execute(array($_SESSION['id']));
			$resultat = $bdd->prepare("SELECT DISTINCT id AS no_programme,nom AS nom_programme,commentaire  FROM programmes WHERE id_utilisateur=? ORDER BY id");
			$resultat->execute(array($_SESSION['id']));
			if(($result_programme->rowCount() == 0) AND ($resultat->rowCount() == 0)){
				echo '<p style="font-size: 2em; background: black; color:white; margin-left:auto;margin-right:auto; width:70%;border-radius:5px;padding:15px;">Vous n\'avez aucun workout, Je vous invite a en créer un nouveau!</p>';
			}
			elseif($result_programme->rowCount() > 0) {
				while ($aff = $result_programme->fetch()) {
					?>
					<div class="conteneur_programme">
						<a <?php echo 'href="workout_detail.php?idprog='.$aff["no_programme"].'"'; ?>>
							<table>
								<tr>
									<th id="titre_programme">
										<?php echo $aff['nom_programme']; ?>
									</th>
								</tr>
								<tr>
									<th id="commentaire_programme">
										<?php echo $aff['commentaire']; ?>
									</th>
								</tr>
							</table>
						</a>
					</div>
					<?php
				}
			}
			else {
				while ($aff = $resultat->fetch()) {
					?>
					<div class="conteneur_programme">
						<a <?php echo 'href="editer_workout.php?idprog='.$aff["no_programme"].'"'; ?>>
							<table>
								<tr>
									<th id="titre_programme">
										<?php echo $aff['nom_programme']; ?>
									</th>
								</tr>
								<tr>
									<th id="commentaire_programme">
										<?php echo $aff['commentaire']; ?>
									</th>
								</tr>
							</table>
						</a>
					</div>
					<?php
				}
			}
			$result_programme->closeCursor();
			$resultat->closeCursor();
			?>
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