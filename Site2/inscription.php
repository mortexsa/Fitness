<?php
session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Fitness - Programme</title>
	<link rel="stylesheet" type="text/css" href="style/style_inscription.css">
</head>

<body>
	<div id="bloc_page">
		<header>
			<div id="photo">
				<img src="Logo-PSF-blanc.png">
			</div>
			<div id="titre_principal">
				<h2>CRÉATION DE PROGRAMMES FITNESS</h2>
				<h4>Il n'a jamais été aussi facile de crée son programme fitness!</h4>
			</div>
		</header>
		<section>
			<?php 
			if(isset($_SESSION['erreur_inscription'])) {
				echo '<div id="affiche_erreur"><p>'.$_SESSION['erreur_inscription'].'</p></div>';
			}
			?>
			<div id="formulaire_connexion">
				<form action="interraction/inscription_test.php" method="post">
					<p><input type="text" name="nom" placeholder="Nom ex: Jean-Michel" id="colone_remplire"></p>
					<p><input type="text" name="prenom" placeholder="Prénom ex: Jean-François" id="colone_remplire"></p>
					<p><input type="text" name="inscri_email" placeholder="Adresse e-mail" id="colone_remplire"></p>
					<p><input type="text" name="date_naissance" placeholder="Date de naissance jj/mm/aaaa" id="colone_remplire"></p>
					<p><input type="tel" name="tel" placeholder="Téléphone ex: 0615478965" id="colone_remplire"></p>
					<p>
						<select name="sexe" id="submit" style="text-align-last: center;">
							<option value="H" selected>Homme</option>
							<option value="F">Femme</option>
						</select>
					</p>
					<p><input type="password" name="inscri_password" placeholder="Tapez votre mot de passe" id="colone_remplire"></p>
					<p><input type="password" name="inscri_password2" placeholder="Retapez votre mot de passe" id="colone_remplire"></p>
					<p><input type="submit" name="submit" value="S'inscrire" id="submit"></p>
				</form>
			</div>
			<div id="pour_connexion">
				<p>Vous êtes déjà inscrit? <a href="index.php">Cliquez içi pour vous connecter</a></p>
			</div>
		</section>
		<footer>
			<p>ddd</p>
		</footer>
	</div>	
</body>
</html>
<?php
	unset($_SESSION['erreur_inscription']);
?>
