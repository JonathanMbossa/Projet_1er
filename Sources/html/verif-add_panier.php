<?php

  if(!isset($_GET['equip']) || empty($_GET['equip']) || !isset($_GET['quantity']) || empty($_GET['quantity'])){
    header('location: equip.php');
    exit;
  }

  session_start();

  if(!isset($_SESSION["id"]) || empty($_SESSION["id"])){
    header('location: inscription.php?message="Connexion requise"');
    exit;
  }

  include('includes/db_connexion.php');

  $v = "SELECT * FROM panier WHERE id_user = :id_user AND id_equip = :id_equip";
  $req_verif = $db->prepare($v);
  $req_verif->execute([
    "id_user" => $_SESSION["id"],
    "id_equip" => $_GET["equip"]
  ]);
  $verif = $req_verif->fetch();

  if($verif["quantity"]){
    $u = 'UPDATE panier SET quantity = quantity + 1 WHERE id_user = :id_user AND id_equip = :id_equip';
    $req_add = $db->prepare($u);
    $req_add->execute([
      "id_user" => $_SESSION["id"],
      "id_equip" => $_GET["equip"]
    ]);
    if($req_add){
      header('location: equip.php?message=Ajouter avec succès.');
      exit;
    } else {
      header('location: equip.php?message=Erreur lors de l\'ajout.');
      exit;
    }
  } else {
    $i = "INSERT INTO panier (id_user,id_equip,quantity) VALUES (:id_user,:id_equip,:quantity)";
    $req_add = $db->prepare($i);
    $req_add->execute([
      "id_user" => $_SESSION["id"],
      "id_equip" => $_GET["equip"],
      "quantity" => $_GET["quantity"]
    ]);
    if($req_add){
      header('location: equip.php?message=Ajouter avec succès.');
      exit;
    } else {
      header('location: equip.php?message=Erreur lors de l\'ajout.');
      exit;
    }
  }

?>
