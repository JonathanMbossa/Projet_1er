<?php

session_start();


//Connexion à la base de données
include('includes/db_connexion.php');

if (isset($_SESSION['email']) && isset($_POST['message']) && !empty($_SESSION['email']) && !empty($_POST['message'])){
      // $pseudo = htmlspecialchars($_SESSION['email']);
      $message = htmlspecialchars($_POST['message']);

      $insertmsg = $db->prepare('INSERT INTO chat(pseudo, message,date_envoie) VALUES (?, ?, NOW())');
      $insertmsg->execute([
          $_SESSION['email'],
          $message
      ]);

      // echo "test";

  if ($insertmsg) {
      header('location: chat.php?message=message bien envoyer');
      exit;
  }else{
      header('location: chat.php?message=erreur lors de l\'envoie du message');
      exit;
  }


} else{
    header('location: chat.php?message=erreur lors de l\'envoie du message');
    exit;
}

?>
