<?php

  if( !isset($_POST['dateFrom']) || empty($_POST['dateFrom']) || !isset($_POST['dateTo']) || empty($_POST['dateTo'])){
  	// Rediriger vers connexion.php avec un message d'erreur
  	header('location: moto_page.php?id='.$_GET["moto"].'&message=Vous devez remplir les 2 champs.');
  	exit;
  }

  if(!isset($_GET['moto']) || empty($_GET['moto'])){
    header('location: moto.php');
  	exit;
  }

  session_start();

  if(!isset($_SESSION["id"]) || empty($_SESSION["id"])){
    header('location: inscription.php?message="Connexion requise"');
    exit;
  }

  include('includes/db_connexion.php');


  $q = 'SELECT * FROM reservation WHERE id_user = :id_user AND id_moto = :id_moto';
  $req = $db->prepare($q);
  $reponse = $req->execute([
  	'id_user' => $_SESSION['id'],
  	'id_moto' => $_GET["moto"]
  ]);
  $verif = $reponse ? $req->fetch() : $reponse;

  if($verif){
    header('location: moto_page.php?id='.$_GET["moto"].'&message=Vous avez déjà réserver cette moto.');
  	exit;
  }

  $p = 'INSERT INTO reservation (id_user, id_moto, date_from, date_to) VALUES (:id_user, :id_moto, :date_from, :date_to)';
  $req = $db->prepare($p);
  $reponse = $req->execute([
    'id_user' => $_SESSION["id"],
    'id_moto' => $_GET["moto"],
    'date_from' => $_POST["dateFrom"],
    'date_to' => $_POST["dateTo"]
  ]);

  if($reponse){
    header('location: moto_page.php?id='.$_GET["moto"].'&message=Reservation enregistrer.');
    exit;
  } else {
    header('location: moto_page.php?id='.$_GET["moto"].'&message=Erreur lors de l\'enregistrement.');
    exit;
  }


?>
