<?php 
session_start();
//On vérifie si le get est bon 
if(isset($_SESSION['id'])){
include("../connexion_bdd/connexionbdd_user.php");
	if(!isset($_GET["idcate"]) AND empty($_GET["q"])) {
		$result_programme = $bdd->query("SELECT DISTINCT no_exercice,nom_exercice,difficulte 
		FROM exercices_par_categorie 
		ORDER BY nom_exercice");
	}
	elseif(isset($_GET["idcate"]) AND !isset($_GET["q"])) {
		$idcate = htmlspecialchars(addslashes($_GET['idcate']));
		$idcate = intval($idcate);
		$result_programme = $bdd->prepare("SELECT * FROM exercices_par_categorie WHERE no_categorie=?");
		$result_programme->execute(array($idcate));
	}elseif(!isset($_GET["idcate"]) AND isset($_GET["q"]) AND !empty($_GET['q'])) {
		$q = htmlspecialchars(addslashes($_GET['q']));
		$result_programme = $bdd->query('SELECT DISTINCT no_exercice,nom_exercice,difficulte FROM exercices_par_categorie WHERE nom_exercice LIKE "%'.$q.'%" ORDER BY nom_exercice');
	} 

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../style/menu.css">
	<link rel="stylesheet" type="text/css" href="../style/contenu_workout_detail.css">
	<link rel="stylesheet" type="text/css" href="../style/footer.css">
	<title>Exercices</title>
	<meta charset="utf-8">
</head>
<body>
	<?php include("menu.php"); ?>
	<div id="conteneur">
		<section>
			<h3>Nos Exercices</h3>
			<h5>Cliquez sur un Éxercice pour afficher son contenu<h5>
			<div class="conteneur_programme">
				<table>
					<tr>
						<th id="titre_programme">
							Voici les exercices
						</th>
					</tr>
					<?php 
					if($result_programme->rowCount() == 0){echo '<th style="color: white;font-size: 2em;padding:10px;">Nous n\'avons trouvé aucun résultats</th>';}
					while($rows = $result_programme->fetch()) {
					?>
					<tr id="commentaire_programme">
						<th><?php echo  '<a href="exercice_detail.php?idexo='.$rows["no_exercice"].'">'.$rows["nom_exercice"].' -> Difficulté : '.$rows["difficulte"]; ?></a></th>
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