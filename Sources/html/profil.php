<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="img/icon.png" />
    <link rel="stylesheet" href="css/test.css">
    <title>Modif profil</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <!-- <? include("includes/verif-connexion.php"); ?> -->
  </head>
  <body>
    <?php
      include('includes/db_connexion.php');
      if(isset($_SESSION['email'])){
        $q = 'SELECT id,email,lastname,firstname,pp,adresse,tel,permis_class,birth_date,permis_img FROM users WHERE email = ?';
        $req = $db->prepare($q);
        $req ->execute([$_SESSION['email']]);
        $user = $req -> fetch();
      }

      if($user["lastname"] && $user["firstname"] && $user["adresse"] && $user["tel"] && $user["permis_class"] && $user["permis_img"] && $user["birth_date"]){
        echo "<style>
                #warn_profil{
                  display:none
                }
              </style>";

      } else {
        echo "<style>#warn_profil{display:block;color:orange}</style>";
      }
    ?>

    <br>
    <br>
    <br>
    <br>
    <div class="container">
      <div class="d-flex justify-content-center">
        <div class="p-2" id="profil-name" style="display: flex; flex-wrap: wrap; justify-content:center;">
          <figure>
            <img src="uploads/photos_profils/<?= $user['pp']  ?>" style="width: 100px; border: 2px solid black; margin:auto; margin-bottom: 10px;" class="rounded-circle">
            <svg style="position: absolute;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
              <input type="file">
              <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
            </svg>
          </figure>
          <h2 id="test" style="tetext-align: center;"><?=$user["firstname"] ."  ".$user["lastname"]?></h2>
          <script>
            let long = document.getElementById("test").offsetWidth;
            long +=20;
            let tata = document.getElementById("profil-name");
            let tete = long.toString()+'px';
            tata.style.width = tete;
          </script>
        </div>
      </div>
      <br>
      <!-- NAV TABS -->
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active"  href="profil.php">Mon profil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="profil_modif.php" style="display:flex; ">Modifier mes informations   <i id="warn_profil" style="margin-left:10px;" class="bi bi-exclamation-octagon-fill"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="profil_gout.php">Mes goûts</a>
        </li>
      </ul>


      <div class="tab-content">
        <!-- INFO PROFIL -->
        <div id="home" class="container tab-pane active"><br>
          <div class="row">
            <div class="col-md-5 col-sm-8">
              <h1>Evenement créer</h1>
              <?php
                $max = $db->query('SELECT max(id) AS _max FROM event'); //requête SQL pour connaitre la taille du tableau
                $id = $max->fetch(PDO::FETCH_ASSOC); //prend la première ligne renvoyer
                $id = $id["_max"] + 1; // Recup l'id max +1

                $t = 'SELECT id FROM event WHERE id_creater = ?';
                $req = $db->prepare($t);
                $req ->execute([$_SESSION['id']]);
                $test = $req -> fetch();

                if($test){
                  for($i = 0; $i < 3; $i++){
                    $q = 'SELECT title,date_event,id FROM event WHERE id_creater = (:id_creater) AND id < (:id)  ORDER BY id DESC';
                    $req = $db->prepare($q);
                    $req ->execute([
                      'id_creater' => $_SESSION['id'],
                      'id' => $id
                    ]);
                    $event = $req -> fetch();
                    $id = $event["id"];
                    if($event){
                      $date = date_create($event["date_event"]);
                      echo '<p>'.$event["title"].' ---- '. date_format($date,"d/m/Y") . '</p>';
                    }
                  }
                } else {
                  echo '<p>Vous n\'avez créer aucun évènement</p>';
                }
              ?>
            </div>

            <div class="col-md-5 col-sm-8">
              <h1>Vos réservations</h1>
              <?php
                $sort = "reservation";
                include('includes/sort.php');

                if($req_min['_min'] && $req_max['_max']){
                  for ($i = $req_min['_min']; $i <= $req_max['_max']; $i++){
                    $req_select = $db->query('SELECT reservation.id, moto.model, moto.marque,reservation.date_from, reservation.date_to FROM reservation,users,moto WHERE reservation.id_moto = moto.id AND reservation.id_user = users.id AND reservation.id = '.$i);
                    $select = $req_select->fetch(PDO::FETCH_ASSOC);
                    if($select){ //vérifie que la ligne existe bien dans la table
                      $date_from = date_create($select["date_from"]);
                      $date_to = date_create($select["date_to"]);
                      echo '<p>'.$select["marque"].' '.$select["model"].' date: du ' .date_format($date_from,'d/m/Y').' au '.date_format($date_to,'d/m/Y').'</p>';
                    }
                  }
                } else {
                  echo '<option>Vide</option>';
                }
              ?>
            </div>

            <div class="col-md-5 col-sm-8">
              <h1>Derniers messages</h1>
            </div>
          </div>
        </div>





          <!-- <div class="case">
            <div class="base" draggable="true"></div>
          </div>
          <div class="case"></div>
          <div class="case"></div>
          <script src="scripts/gout.js"></script> -->
        </div>
      </div>
    </div>
  </body>
</html>
