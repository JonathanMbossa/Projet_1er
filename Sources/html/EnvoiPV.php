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
  if (isset($_POST['envoi_message'])) { // on vérifie si les variables existe
    if (isset($_POST['destinataire'],$_POST['message']) && !empty($_POST['destinataire']) && !empty($_POST['message'])) {

      $destinataire = htmlspecialchars($_POST['destinataire']);
      $message = htmlspecialchars($_POST['message']);

      $id_destinataire = $db->prepare('SELECT id FROM users WHERE email = ?');
      $id_destinataire->execute(array($destinataire));

      $dest_exist = $id_destinataire->rowCount();
      if ($dest_exist == 1) {

        $id_destinataire = $id_destinataire->fetch();
        $id_destinataire = $id_destinataire['id']; // récupére l'id de ce tableau

        $insert = $db->prepare('INSERT INTO messagepv(id_expediteur, id_destinataire,message) VALUES (?,?,?)');
        $insert->execute(array($_SESSION['id'], $id_destinataire, $message));

        $error = "Votre message à bien était envoyé :";
      }else{
          $error = "Cette utilisateur n'existe pas"; // affiche si il y'a une erreur
      }


    }else {
      $error = "Veuillez compléter tous les champs"; // affiche si il y'a une erreur
    }
  }

  $destinataires = $db->query('SELECT email FROM users');
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
      <form  method="post">

        <select name="destinataire" class="form-control" style="margin-top:3em";>

          <?php while($d = $destinataires->fetch()) { // affichhe tout les destinataire ?>
            <option><?= $d['email']?></option>
          <?php  } ?>

        </select>

        <br><br>

        <textarea class="form-control"  placeholder="Votre message" name="message"></textarea><br>

        <div id="BUTTON" >
          <input type="submit" class="btn btn-outline-success" value="Envoyer" name="envoi_message">
          <?php if (isset($error)) {
            echo '<span style="color:red">' . $error. '</span>';
          } ?>
        </div>

      </form>
      <br>
      <a href="ReceptionPV.php">Boite de réception</a>
    </body>
  </html>

<?php
  }
?>
