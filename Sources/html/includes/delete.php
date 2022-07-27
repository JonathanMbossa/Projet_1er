<?php
// Connexion à la base de données
include('db_connexion.php');
session_start();


$del = 'DELETE FROM '.$_GET['table'].' WHERE id = '. $_POST['delete'];
$delet = $db->prepare($del);
$delete = $delet->execute();
if($delete){
  // Ecrire une ligne dans le fichier log_admin.txt
  // Ouvrir le fichier ou le créer si besoin
  $log = fopen('../backoffice/log_admin.txt', 'a+');
  // Création de la ligne à ajouter au log
  $line = date("Y/m/d - H:i:s") . ' - SUPPRESSION '.strtoupper($_GET['table']).': id = ' . $_POST['delete'] . ' -- par '. $_SESSION["id"] . "\n";
  fputs($log, $line);
  fclose($log);
  header('location: ../backoffice/db_'.$_GET['table'].'.php?message=Supression réussite.&type=success');
} else {
  header('location: ../backoffice/db_'.$_GET['table'].'.php?message=Erreur lors de la suppression.&type=danger');
}
?>
