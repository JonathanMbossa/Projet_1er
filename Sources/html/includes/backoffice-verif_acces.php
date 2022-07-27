<?php
session_start();

if(!isset($_SESSION["email"])){
  header('location: ../index.php?message=Vous n\'avez pas accès à ce contenue.');
  exit;
}


include("db_connexion.php");
// Verif si admin
$q = 'SELECT admin,firstname,lastname FROM users WHERE email = :email';
$req = $db->prepare($q);
$req->execute([
  'email' => $_SESSION['email']
]);
$reponse = $req ->fetch();

if(!$reponse["admin"]){
header('location: ../index.php?message=Vous n\'avez pas accès à ce contenue.');
exit;
}

if(!$reponse["firstname"] || !$reponse["lastname"]){
  header('location: ../index.php?message=merci de mettre a jour votre nom et prenom pour acceder a ce contenue');
  exit;
}
?>
