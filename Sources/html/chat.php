<?php
//Connexion à la base de données
include('includes/db_connexion.php');
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <meta http-equiv="refresh" content="1"> -->
    <title>tchat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
     rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
      crossorigin="anonymous">
      <link rel="stylesheet" href="style.css">

  </head>
  <body style="margin:2em 2em;" class="azerty">
    <?php
    $allmsg = $db->query('SELECT * FROM chat ORDER BY id DESC LIMIT 0, 5');

    $all = $allmsg->fetchAll() ;
    for ($i = count($all) - 1 ; $i >= 0 ; --$i) {
        $msg = $all[$i] ;
        ?><div class="card bg-light mb-3 mb-3 dropdown-menu border-dark  " style="padding-left: 10px;">
        <b><?= $msg['pseudo'] ?> : </b> <?= $msg['message'] ?><br> <?=// boucle en arrère en partant du dernier point du tableau vers le premier
          ("envoyé le  " . $msg['date_envoie']);
        ?><br></div>

    <?php } ?>
    <form action="verifchat.php" method="post">
      <div class="form-group">
        <!-- <div class="row"> -->
          <div class="col-md-6 ">
            <input type="text" class="form-control" name="message" style="margin-bottom:1em;" placeholder="MESSAGE">
            <input type="submit" class="btn btn-primary" value="Envoyer">
            <a href="Mreport.php">Signalé un utilisateur</a>
          </div>
        <!-- </div> -->
      </div>
    </form>


    <!-- <script src="reload.js" charset="utf-8"></script> -->

  </body>
</html>
