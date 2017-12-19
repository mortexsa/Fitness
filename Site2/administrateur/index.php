<?php 

include("connexionbdd_admin.php");
$result_programme = $bdd->query("SELECT DISTINCT no_exercice,nom_exercice,difficulte 
		FROM exercices_par_categorie 
		ORDER BY nom_exercice");
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
			<h3>Nos Exercices</h3>
			<div id="boutton_creation" style="margin-top: 40px; margin-bottom: 40px;">	
				<a href="creer_exercice.php">Creer un Exercice</a>
				</div>
			<div class="conteneur_programme">
			<h5>Choisissez un exercice que vous voulez éditer<h5>
				<form method="post" action="editer_exercice.php">
					<select style="text-align-last: center; font-size: 1.2em;" name="idexo" id="submit">
						<?php 
						while($row = $result_programme->fetch()){
							echo '<option value="'.$row['no_exercice'].'">'.$row['nom_exercice'].'</option>';
						}
						?>
					</select>
					<p>
						<input style="font-size: 1.2em;" type="submit" id="submit" name="submit2" value="Editer">
					</p>
				</form>

			</div>
		</section>
	</div>
	<?php include("../utilisateur/footer.php"); ?>
</body>
</html>
