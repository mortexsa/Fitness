<?php 
session_start();
//On vérifie si le get est bon 
if(isset($_SESSION['id'])){
include("../connexion_bdd/connexionbdd_user.php");
	if(isset($_GET['idprog']) AND !empty($_GET['idprog'])) {
		$idprog = htmlspecialchars(addslashes($_GET['idprog']));
		$idprog = intval($idprog);
			$result_programme = $bdd->query("SELECT DISTINCT no_exercice,nom_exercice AS nom_exercice_restant,difficulte 
		FROM exercices_par_categorie 
		ORDER BY nom_exercice");
		
		if(isset($_POST['submit'])) {
			if(!empty($_POST["idexo"]) && !empty($_POST["nbr_rep"])) {
				extract($_POST);
				$idexo = intval($idexo);
				$nbr_rep = intval($nbr_rep);
				$verifie = $bdd->prepare("SELECT * FROM programmes_utilisateur WHERE no_programme=? AND no_exercice=?");
				$verifie->execute(array($idprog,$idexo));
				if($verifie->rowCount() == 0){
					$insertexo = $bdd->prepare("INSERT INTO contient(id_programme, id_exercice, nbr_repetition) VALUES(?,?,?)");
					$insertexo->execute(array($idprog, $idexo, $nbr_rep));
				}
				else {
					$erreur = "Cette exercice figure deja dans le programme.";
				}
			}
		}
		$result_final = $bdd->prepare("SELECT DISTINCT no_programme,nom_programme,no_exercice,nom_exercice,nbr_repetition 
		FROM programmes_utilisateur 
		WHERE no_utilisateur=? AND no_programme=? 
		ORDER BY nom_exercice");
		$result_final->execute(array($_SESSION['id'],$idprog));

		if(isset($_GET['idexo']) && !empty($_GET['idexo'])){
			$idexo = htmlspecialchars(addslashes($_GET['idexo']));
			$idexo = intval($idexo);
			$supprimerexo = $bdd->prepare("DELETE FROM contient WHERE id_programme=? AND id_exercice=?");
			$supprimerexo->execute(array($idprog,$idexo));
			header('Location: editer_workout.php?idprog='.$idprog);
		}
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
			<div class="bloque_exo">
				<h2>Liste des exercices non contenu dans le Workout</h2>
				
				<?php 
				if(isset($erreur)){
					echo "<h3 style='color:red;'>".$erreur."</h3>";
				}
				while ($rows = $result_programme->fetch()){
					echo '<form method="post" action="">'.
					'<p><input type="radio" checked="checked" name="idexo" value="'.$rows["no_exercice"].'">'.$rows["nom_exercice_restant"].' [Difficulté: '.$rows['difficulte'].'] -> nombre de répétitions : '.
					'<input type="number" name="nbr_rep" value="1" min="1" max="10" >'.
					'<input type="submit" name="submit" value="Ajouter" ></p>'.
					'</form>';
				}
				?>
				<div class="conteneur_programme">
				<table>
					<tr>
						<th id="titre_programme">
							<?php
							$rows3 = $result_final->fetch(); 
							echo $rows3["nom_programme"]; 
							?>
						</th>
					</tr>
					<h2>Cliquez sur un exercice pour le suprimer !</h2>
					<?php 
					do {
					?>
					<tr id="commentaire_programme">
						<th><?php echo  '<a href="editer_workout.php?idprog='.$idprog.'&idexo='.$rows3["no_exercice"].'">'.'Exo : '.$rows3["nom_exercice"].' -> '.$rows3["nbr_repetition"].' répétitions'; ?></a></th>
					</tr>
					<?php
					} while($rows3 = $result_final->fetch())
					?>
				</table>
			</div>
			</div>

			
		</section>
	</div>
	<?php include("footer.php"); ?>
</body>
</html>

<?php
	$insertexo->closeCursor();
	$result_programme->closeCursor();	
}
else {
	header('Location: ../index.php');
}	
?>