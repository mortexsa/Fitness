<?php
print "<html><head><title>Test Connexion</title></head><body>";
$link = new mysqli('localhost', 'root', '159753Ena,;:');
if ($link->connect_errno) {
 die("Erreur de connexion : errno: " . $link->errno . " error: ". $link->error);
}
$link->select_db('fitness') or die("Erreur selection BD: " . $link->error);
print "connexion ok !";
print "</body></html>";
?>