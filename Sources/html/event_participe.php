<?php
session_start();
if(!isset($_SESSION["id"]) || empty($_GET['id'])){
  header("location: event_list.php");
  exit;
}

// Connexion à la base de données
include("includes/db_connexion.php");

$req_verif = $db->prepare('SELECT * FROM participe WHERE id_user = ? AND id_event = ?');
$req_verif->execute([$_SESSION["id"],$_GET['id']]);
$verif = $req_verif->fetch();

if($_GET["action"] == "participe"){
  if(!$verif){
    $p = 'INSERT INTO participe (id_event, id_user) VALUES (:id_event, :id_user)';
    $req_part = $db->prepare($p);
    $req_part->execute([
      "id_event" => $_GET["id"],
      "id_user"  => $_SESSION["id"]
    ]);
  } else {
    header('location: event_page.php?id='.$_GET["id"].'&message=Vous participer déjà à cet event.');
  	exit;
  }
  if($req_part){
  	header('location: event_page.php?id='.$_GET["id"].'&message=Participation enregistrer.');
  	exit;
  }else{
  	header('location: event_page.php?id='.$_GET["id"].'&message=Echec de l\'enregistrement de la participation.');
  	exit;
  }

} else {
  if($verif){
    $p = 'DELETE FROM participe WHERE id_event = :id_event AND id_user = :id_user';
    $req_part = $db->prepare($p);
    $req_part->execute([
      "id_event" => $_GET["id"],
      "id_user"  => $_SESSION["id"]
    ]);
  } else {
    header('location: event_page.php?id='.$_GET["id"].'&message=Vous ne participez pas à cet event.');
    exit;
  }
  if($req_part){
    header('location: event_page.php?id='.$_GET["id"].'&message=Annulation de la participation.');
    exit;
  }else{
    header('location: event_page.php?id='.$_GET["id"].'&message=Echec lors de l\'annulation.');
    exit;
  }
}
