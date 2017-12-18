<?php 
session_start();
//On vérifie si le get est bon 
if(isset($_SESSION['id'])){
include("../connexion_bdd/connexionbdd_user.php");
	$result_programme = $bdd->query("SELECT DISTINCT no_categorie,muscle 
		FROM exercices_par_categorie 
		ORDER BY muscle");
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../style/menu.css">
	<link rel="stylesheet" type="text/css" href="../style/contenu_workout_detail.css">
	<link rel="stylesheet" type="text/css" href="../style/footer.css">
	<title>Categories</title>
	<meta charset="utf-8">
</head>
<body>
	<?php include("menu.php"); ?>
	<div id="conteneur">
		<section>
			<h3>Nos Catégories</h3>
			<h5>Cliquez sur une Catégories pour afficher les exercices adéquat au muscle choisi<h5>
			<div class="conteneur_programme">
				<table>
					<tr>
						<th id="titre_programme">
							Muscles visés
						</th>
					</tr>
					<?php 
					while($rows = $result_programme->fetch()) {
					?>
					<tr id="commentaire_programme">
						<th><?php echo  '<a href="exercices.php?idcate='.$rows["no_categorie"].'">'.$rows["muscle"]; ?></a></th>
					</tr>
					<?php
					} 
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
	header('Location: ../index.php');
}	
?>