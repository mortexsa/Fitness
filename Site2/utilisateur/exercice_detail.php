<?php 
session_start();
//On vérifie si le get est bon 
if(isset($_SESSION['id']) AND isset($_GET['idexo'])){
	include("../connexion_bdd/connexionbdd_user.php");
	$idexo = htmlspecialchars(addslashes($_GET['idexo']));
	$idexo = intval($idexo);
	$result_programme = $bdd->prepare("SELECT * FROM exercices WHERE id=?");
	$result_programme->execute(array($idexo));
	if($result_programme->rowCount() == 1){
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../style/menu.css">
	<link rel="stylesheet" type="text/css" href="../style/contenu_workout_detail.css">
	<link rel="stylesheet" type="text/css" href="../style/footer.css">
	<link rel="stylesheet" type="text/css" href="../style/exercice_detail.css">
	<title>Workouts</title>
	<meta charset="utf-8">
</head>
<body>
	<?php include("menu.php"); ?>
	<div id="conteneur">
		<section>
			<?php 
				$rows = $result_programme->fetch();
			?>
			<div id="nom_exo">
				<h1><?php echo $rows["nom"]; ?></h1>
			</div>
			<div>
				<h3>Niveau de difficulté : <?php echo $rows["difficulte"]; ?></h3>
			</div>
			<div id="bon_savoir" style="text-align: left;">
				<h3>Bon à savoir :</h3>
			</div>
			<p><?php echo $rows["courte_description"]; ?></p>
			<div id="bon_savoir" style="text-align: left;">
				<h3>Déscription :</h3>
			</div>
			<p><?php echo $rows["description"]; ?></p>
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
		header('Location: exercices.php');
	}	
}
else {
	header('Location: ../index.php');
}	
?>