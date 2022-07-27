<?php

include('db_connexion.php');

$q = 'SELECT firstname,lastname FROM users WHERE email = :email';
$req = $db->prepare($q);
$req->execute([
  'email' => $_SESSION['email']
]);
$reponse = $req ->fetch();

$ip = explode('/',$_SERVER['REQUEST_URI']);

if(!$reponse["firstname"] || !$reponse["lastname"]){
  // si n'est pas admin, redirige vers l'index
  header('location: ../'. end($ip) .'?message=Merci de mettre a jour votre nom et prénom pour accéder à ce contenue');
  exit;
}


?>
