<?php 
session_start();
//On vérifie si le get est bon 
if(isset($_SESSION['id'])){
	include("../connexion_bdd/connexionbdd_user.php");
	$result_programme = $bdd->prepare("SELECT * FROM utilisateurs WHERE id=?");
	$result_programme->execute(array($_SESSION['id']));
	if($result_programme->rowCount() == 1){
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../style/menu.css">
	<link rel="stylesheet" type="text/css" href="../style/contenu_workout_detail.css">
	<link rel="stylesheet" type="text/css" href="../style/profil.css">
	<link rel="stylesheet" type="text/css" href="../style/footer.css">
	<title>Profil</title>
	<meta charset="utf-8">
</head>
<body>
	<?php include("menu.php"); 
	$rows = $result_programme->fetch();
	?>
	<div id="conteneur">
		<section>
			<h1>Mon profil</h1>
			<?php 
			if(isset($_GET["id"]) AND !empty($_GET["id"]) AND $_GET["id"] == $_SESSION["id"]){
				if (isset($_POST["submit"])) {
					if(!empty($_POST['password_change']) AND !empty($_POST['sec_password_change'])) {
						extract($_POST);
						if(strlen($password_change)>7 && strlen($password_change)<77){
							$password_change = sha1($password_change);
							$sec_password_change = sha1($sec_password_change);
							
							//On verifie si les mot de passe sont egaux
							if($password_change == $sec_password_change){
								if($password_change != $rows["password"]){
									$req = $bdd->prepare('UPDATE utilisateurs SET password ="'.$password_change.'" WHERE id=?');
									$req->execute(array($_SESSION['id']));
									$req->closeCursor();
									$erreur_inscription = "Votre mot de passe à bien été modifier";
								}
								else {
									$erreur_inscription = "Entrez un mot de passe autre que l'ancien";
								}
							}
							else {
								$erreur_inscription = "Veuillez entrez des mot de passe identiques";
							}
						}
						else {
							$erreur_inscription = "Entrez un Mot de passe compris entre 8 et 76 caractères";
						}
					}
					else {
						$erreur_inscription = "Tous les champs sont obligatoires";
					}
				}
				if(isset($erreur_inscription) AND !empty($erreur_inscription)) {
				echo '<div id="affiche_erreur"><p>'.$erreur_inscription.'</p></div>';
				}
			?>
			<form method="post" action="">
				<p><input type="password" name="password_change" id="colone_remplire" placeholder="Tapez votre mot de passe"><p>
				<p><input type="password" name="sec_password_change" id="colone_remplire" placeholder="Retapez votre mot de passe"><p>
				<p><input type="submit" name="submit" value="Valider les modifications" id="submit"><p>
			</form>
			<p><a href="profil.php">Retourner à mon profil</a>
			<?php
			}
			else {
			?>
			<table>
				<tr>
					<th>
						Nom : 
					</th>
					<th>
						<?php echo $rows["nom"]; ?>
					</th>
				</tr>
				<tr>
					<th>
						Prénom : 
					</th>
					<th>
						<?php echo $rows["prenom"]; ?>
					</th>
				</tr>
				<tr>
					<th>
						E-mail : 
					</th>
					<th>
						<?php echo $rows["email"]; ?>
					</th>
				</tr>
				<tr>
					<th>
						Date de naissance : 
					</th>
					<th>
						<?php echo $rows["date_naissance"]; ?>
					</th>
				</tr>
				<tr>
					<th>
						Téléphone : 
					</th>
					<th>
						<?php echo $rows["tel"]; ?>
					</th>
				</tr>
				<tr>
					<th>
						Sexe : 
					</th>
					<th>
						<?php 
						if($rows["sexe"] == "F") {echo "Femme";}
						else {echo "Homme";}
						 ?>
					</th>
				</tr>
			</table>
			<div id="boutton_creation">	
				<a href=<?php echo 'profil.php?id='.$rows['id']; ?>>Changer mon Mot de passe</a>
			</div>
			<?php } ?>
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