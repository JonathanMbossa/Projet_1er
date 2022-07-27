<?php

  if(!isset($_POST["id_reserv"]) || empty($_POST["id_reserv"]) || !isset($_POST["longitude"]) || empty($_POST["longitude"]) || !isset($_POST["latitude"]) || empty($_POST["latitude"])){
    header('location: add_location.php?message=Merci de remplir tout les champs');
    exit;
  }

  include('../includes/db_connexion.php');

  $s = 'SELECT MAX(locater_count) FROM locater WHERE id_reservation = ?';
  $req_select = $db->prepare($s);
  $req_select->execute([
    $_POST['id_reserv']
  ]);
  $select = $req_select->fetch();

  $count = $select[0] != NULL ? $select[0]+1 : 0 ;

  $i = 'INSERT INTO locater (id_reservation, locater_count, lat, lon) VALUES (:id_reservation, :locater_count, :lat, :lon)';
  $req_insert = $db->prepare($i);
  $insert = $req_insert->execute([
    'id_reservation' => $_POST['id_reserv'],
    'locater_count' => $count,
    'lat' => $_POST['latitude'],
    'lon' => $_POST['longitude']
  ]);

  if($insert){
    header('location: add_location.php?message=Ajouter avec succès');
    exit;
  } else {
    header('location: add_location.php?message=Erreur');
    exit;
  }

?>
