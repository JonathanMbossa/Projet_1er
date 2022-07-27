<?php
  include('includes/db_connexion.php');
    $delete = 'DELETE  FROM users WHERE email = ? ';
    $del = $db->prepare($delete);
$reponse = $del->execute([
  $_SESSION['email']
]);

          if ($reponse != NULL)
          {
            header('location:inscription.php?message=Compte Supprimer.');
          	die();
          }else{
            header('location:inscription.php?message=impossible de supprimer votre compte.');
          	die();
          }

 ?>
