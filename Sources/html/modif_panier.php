<?php

  if(!isset($_GET["id"]) || empty($_GET["id"])){
    header('location: panier.php');
    exit;
  }

  session_start();
  if(!isset($_SESSION["id"])){
    header('location: index.php');
    exit;
  }


  include('includes/db_connexion.php');

  if(isset($_POST["quantity"]) && !empty($_POST["quantity"])){
    $u = 'UPDATE panier SET quantity = ? WHERE id_equip = ? AND id_user = ?';
    $req_update = $db->prepare($u);
    $update = $req_update->execute([
      (int)$_POST["quantity"],
      $_GET["id"],
      $_SESSION["id"]
    ]);
    if($update){
      header('location: panier.php');
      exit;
    } else {
      header('location: panier.php?message=erreur');
      exit;
    }
  }

  $d = "DELETE FROM panier WHERE id_equip = ? AND id_user = ?";
  $req_delete = $db->prepare($d);
  $delete = $req_delete->execute([$_GET["id"],$_SESSION['id']]);
  if($delete){
    header('location: panier.php');
    exit;
  } else {
    header('location: panier.php?message=Erreur');
    exit;
  }
?>
