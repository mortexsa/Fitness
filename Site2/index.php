<?php 
	session_start(); 
	if(!isset($_SESSION['id'])) {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Fitness - Programme</title>
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<link rel="stylesheet" type="text/css" href="style/footer.css">
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
			
			<?php 
			if(isset($_SESSION['erreur'])) {
				echo '<div id="affiche_erreur"><p>'.$_SESSION['erreur'].'</p></div>';
			}
			?>
			

			<div id="formulaire_connexion">
				<form action="interraction/connexion.php" method="post">
					<p><input type="email" name="email" placeholder="Adresse e-mail" id="email"></p>
					<p><input type="password" name="password" placeholder="Mot de passe" id="password"></p>
					<p><input type="submit" name="submit" value="Connexion" id="submit"></p>
				</form>
			</div>
			<div id="pour_inscrire">
			<p>Vous n'avez pas de compte? <a href="inscription.php">Cliquez içi pour vous inscrire</a></p>
			</div>
		</header>
		<section>
		</br></br>
		<div style="text-align: center; border: 2px solid black; margin-bottom: 40px;">
			<h2>
				Bienvenue sur Mon site de création de workouts
			</h2>
			</br></br></br>
			<h4>
				Se site vous permettra d'apprendre de nouveau exercices fitness, de les ranger dans des workout, de les modifier a volenter, et de les consulter a tout moment !!
			</h4>
			</br></br></br>
			<p>
				Pour cela vous devez biensur vous inscrire !!!
			</p>
		</div>
			
		</section>
		<?php include("utilisateur/footer.php"); ?>
	</div>	
</body>

</html>
<?php unset($_SESSION['erreur']); 
}
else {
	header("Location: utilisateur/workouts.php");
}

?>