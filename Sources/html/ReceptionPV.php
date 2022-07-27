<?php
session_start();

// try{
//   $db = new PDO('mysql:host=localhost;dbname=messagepv', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
// }catch(Exception $e){
//   die('Erreur : ' . $e->getMessage()); // Si erreur, afficher le message d'erreur
// }
//Connexion à la base de données
include('includes/db_connexion.php');

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
  $msg = $db->prepare('SELECT * FROM messagepv WHERE id_destinataire = ?'); // $id_destinataire == notre id a nous pour récupérer les messages qui nous corresponde
  $msg->execute(array($_SESSION['id']));
  $msg_nbr = $msg->rowCount();
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Envoie message PV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
    crossorigin="anonymous">
    <link rel="stylesheet" href="stylee.css">
</head>
  <body>
    <a href="EnvoiPV.php">Nouveau message</a><br><br><br>
    <h3>Vos boite de réception : </h3>
<?php // nl2br Insère un retour à la ligne HTML à chaque nouvelle ligne
if ($msg_nbr == 0) { echo "Vous n'avez aucun message..."; }

  while ($m = $msg->fetch()) {
  $email_exp = $db->prepare('SELECT email FROM users WHERE id = ? ');
  $email_exp->execute(array($m['id_expediteur']));
  $email_exp =   $email_exp->fetch();
  $email_exp =   $email_exp['email'];
  ?>
  <b><?= $email_exp ?></b> Vous à envoyeé :
  <?= nl2br($m['message']) ?>
  <hr width='100'>
<?php } ?>

  </body>
</html>
<?php } ?>
