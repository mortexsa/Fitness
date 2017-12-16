<?php 
session_start();
if(isset($_SESSION['id'])){
?>

<!DOCTYPE html>
<html>
<head>
	<title>Accueil</title>
</head>
<body>
	<p><a href="deconnexion.php">Se deconnecter</a></p>
</body>
</html>

<?php	
}
else {
	header('Location: ../index.php');
}	
?>