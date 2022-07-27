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
          <a class="nav-link" href="profil.php">Mon profil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profil_modif.php" style="display:flex; ">Modifier mes informations   <i id="warn_profil" style="margin-left:10px;" class="bi bi-exclamation-octagon-fill"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link active"  href="profil_gout.php">Mes goûts</a>
        </li>
      </ul>
      <div id="gouts"><br>
        <form action="modif_profile.php" method="post">
          <select class="form-control" name="gout1">
            <option selected>
              <?php
                $req_select = $db->query('SELECT gout1 FROM gouts,users WHERE gouts.id_user = users.id AND users.id = '.$_SESSION["id"]);
                $select = $req_select->fetch(PDO::FETCH_ASSOC);
                if($select){
                  echo $select['gout1'];
                } else {
                  echo '...';
                }
              ?>
            </option>
            <option value="Renontre">Rencontre</option>
            <option value="Montagne">Montagne</option>
            <option value="Plat">Plat</option>
            <option value="Foret">Fôret</option>
            <option value="Circuit">Circuit</option>
            <option value="Course">Course</option>
          </select>
          <br>
          <select class="form-control" name="gout2">
            <option selected>
              <?php
                $req_select = $db->query('SELECT gout2 FROM gouts,users WHERE gouts.id_user = users.id AND users.id = '.$_SESSION["id"]);
                $select = $req_select->fetch(PDO::FETCH_ASSOC);
                if($select){
                  echo $select['gout2'];
                } else {
                  echo '...';
                }
              ?>
            </option>
            <option value="Renontre">Rencontre</option>
            <option value="Montagne">Montagne</option>
            <option value="Plat">Plat</option>
            <option value="Foret">Fôret</option>
            <option value="Circuit">Circuit</option>
            <option value="Course">Course</option>
          </select>
          <br>
          <select class="form-control" name="gout3">
            <option selected>
              <?php
                $req_select = $db->query('SELECT gout3 FROM gouts,users WHERE gouts.id_user = users.id AND users.id = '.$_SESSION["id"]);
                $select = $req_select->fetch(PDO::FETCH_ASSOC);
                if($select){
                  echo $select['gout3'];
                } else {
                  echo '...';
                }
              ?>
            </option>
            <option value="Renontre">Rencontre</option>
            <option value="Montagne">Montagne</option>
            <option value="Plat">Plat</option>
            <option value="Foret">Fôret</option>
            <option value="Circuit">Circuit</option>
            <option value="Course">Course</option>
          </select>
          <br>
          <input class="btn btn-primary" id="btn" type="submit" value="Modifier">
        </form>
    </div>
  </body>
</html>
