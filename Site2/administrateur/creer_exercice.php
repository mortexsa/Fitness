<?php 

include("connexionbdd_admin.php");
$result_programme = $bdd->query("SELECT DISTINCT no_categorie,muscle 
		FROM exercices_par_categorie 
		ORDER BY muscle");
if(isset($_POST['submitt'])){
	extract($_POST);
	$nom = ucfirst(strtolower(htmlspecialchars(strip_tags($nom))));
	$courte_description = htmlspecialchars($courte_description);
	$description = htmlspecialchars($description);
	for($i=0; $i<sizeof($categories);$i++){
		$categories[$i] = htmlspecialchars($categories[$i]);
	}
	if(!empty($_POST['nom']) && !empty($_POST['courte_description']) 
		&& !empty($_POST['description']) && !empty($_POST['difficulte'])
		&& !empty($_POST['categories'])) {
		if(preg_match("#^[\p{L}]{3,20}(\-[\p{L}]{2,20}){0,1}$#", $nom)){
			if(strlen($courte_description)>10){
				if(strlen($description)>40) {
					if($difficulte == "facile" || $difficulte == "moyen" || $difficulte == "difficile") {
						$req2 = $bdd->prepare("SELECT nom FROM exercices WHERE nom = ?");
						$req2->execute(array($nom));
						$nom_exist = $req2->rowCount();
						if($nom_exist){
							$erreur = "Cette exercice existe dèja";
						}
						else {
							$insertuser = $bdd->prepare("INSERT INTO exercices(nom,description,courte_description, difficulte) VALUES(?,?,?,?)");
							
							$insertuser->execute(array($nom, $description, $courte_description, $difficulte));
							$insertuser->closeCursor();
							$idexercice = $bdd->prepare("SELECT id FROM exercices WHERE nom = ?");
							$idexercice->execute(array($nom));
							$row4 = $idexercice->fetch();
							for($i=0; $i<sizeof($categories);$i++){
								$insertuser = $bdd->prepare("INSERT INTO appartient(id_exercice,id_categorie) VALUES(?,?)");
								$insertuser->execute(array($row4['id'], $categories[$i]));	
							
							}
							$idexercice->closeCursor();
							$insertuser->closeCursor();
							header('Location: index.php');
							exit();
						}
					}
					else {
						$erreur = "Fait pas le malin";
					}
				}
				else {
					$erreur = "Le commentaire doit contenir au moins 40 caractères";
				}
			}
			else {
				$erreur = "Le court commentaire doit contenir au moins 10 caractéres";
			}
		}
		else {
			$erreur = "Le nom doit contenir entre 3 et 40 caractères";
		}
	}
	else {
		$erreur = "Tous les champs sont obligatoires";
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
			<h3>A vous de jouer !!!</h3>
			<?php
			if(isset($erreur) AND !empty($erreur)) {
			echo '<div id="affiche_erreur"><p>'.$erreur.'</p></div>';
			}
			?>
			<form method="post" action="">
				<p>
					<input type="text" id="colone_remplire" name="nom" placeholder="Nom de l'éxercice" 
					<?php if(isset($nom)){echo 'value="'.$nom.'"';}?> 
					maxlength="69" >  
				</p>
				<p>
					<textarea name="courte_description" placeholder="Courte déscription" id="colone_remplire"><?php if(isset($courte_description)){
						echo $courte_description;}?></textarea>
				</p>
				<p>
					<textarea name="description" placeholder="Contenue de l'éxercice" id="colone_remplire2"><?php if(isset($description)){echo $description;}?></textarea>
				</p>
				<p>
					<p>Difficulté :</p>
					<select style="text-align-last: center; font-size: 1.2em;" name="difficulte" id="submit">
						<option value="facile">Facile</option>
						<option value="moyen">Moyen</option>
						<option value="difficile">difficile</option>
					</select>
				</p>
				<p>Catégories :
				<?php
				while($rows = $result_programme->fetch())
					echo '</br><input type="checkbox" name="categories[]" value="'.$rows['no_categorie'].'"><label>'.$rows['muscle'].'</label>';
				?>
				</p>
				<p>
					<input type="submit" id="submit" name="submitt" value="Valider">
				</p>
			</form>
		</section>
	</div>
	<?php include("../utilisateur/footer.php"); ?>
</body>
</html>
<?php $result_programme->closeCursor(); ?>
