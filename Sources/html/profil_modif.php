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

      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link" href="profil.php">Mon profil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="profil_modif.php" style="display:flex; ">Modifier mes informations   <i id="warn_profil" style="margin-left:10px;" class="bi bi-exclamation-octagon-fill"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="profil_gout.php">Mes goûts</a>
        </li>
      </ul>

      <style>
      .border-span {
        display: block;
        position: relative;
      }
      .border-span > span {
        position: absolute;
        font-size: 75%;
        opacity: 1;
        top: -.5em;
        left: 0.75rem;
        z-index: 3;
        line-height: 1;
        padding: 0 1px;
      }
      .border-span > span::after {
        content: " ";
        display: block;
        position: absolute;
        background: white;
        height: 2px;
        top: 50%;
        left: -.2em;
        right: -.2em;
        z-index: -1;
      }


      </style>
      <!-- MODIF PROFIL -->
      <div id="parametre"><br>
        <form action="modif_profile.php" method="post" enctype="multipart/form-data">

          <div class="mb-3">
            <div style="display:flex; justify-content: space-between">
              <div class="form-group border-span">
                <input class="form-control" style="width:33vw; <?=$user['firstname'] ? '' : 'border: 1px solid orange;'?>" type="text" name="firstname" placeholder="<?=$user["firstname"] ? $user["firstname"] : "Prénom"?>">
                <?=$user["firstname"] ? '<span>Prénom</span>' :''?>
              </div>
              <div class="form-group border-span">
                <input class="form-control" style="width:33vw; <?=$user['lastname'] ? '' : 'border: 1px solid orange;'?>" type="text" name="lastname" placeholder="<?=$user["lastname"] ? $user["lastname"] : "Nom"?>">
                <?=$user["lastname"] ? '<span>Nom</span>' :''?>
              </div>
            </div>
          </div>

          <fieldset disabled> <!--Affiche l'email mais ne permet pas la modif -->
            <div class="mb-3">
              <div class="form-group border-span" style="display:flex">
                <input class="form-control disable" type="email" value="<?=$_SESSION["email"]?>"><i class="bi bi-lock-fill" style="position:absolute;right:10px;top:5px;"></i>
                <span>Email</span>
              </div>
            </div>
          </fieldset>

          <div class="mb-3">
            <div class="form-group border-span">
              <input class="form-control" style="<?=$user['tel'] ? '' : 'border: 1px solid orange;'?>" type="text" name="tel" placeholder="<?=$user["tel"] ? $user["tel"] : "Numéro de téléphone"?>">
              <?=$user["tel"] ? '<span>Téléphone</span>' :''?>
            </div>
          </div>

          <div class="mb-3">
            <div class="form-group border-span">
              <input class="form-control" style="<?=$user['adresse'] ? '' : 'border: 1px solid orange;'?>" type="text" name="adresse" placeholder="<?=$user["adresse"] ? $user["adresse"] : "Adresse"?>">
              <?=$user["adresse"] ? '<span>Adresse</span>' :''?>
            </div>
          </div>

          <div class="mb-3">
            <div class="form-group border-span">
              <input class="form-control" style="<?=$user['birth_date'] ? '' : 'border: 1px solid orange;'?>" type="date" name="birth_date" value="<?= $user["birth_date"] ?  date_format(date_create($user["birth_date"]),('Y-m-d')) : " "?>">
              <?=$user["birth_date"] ? '<span>Date de naissance</span>' :''?>
            </div>
          </div>

          <div class="custom-file">
            <label class="custom-file-label" style="<?=$user['pp'] != 'default_user.png' ? '' : 'border: 1px solid orange;'?>" for="inputGroupFile01">Photo de profil</label>
            <input type="file" class="custom-file-input" name="pp" accept="image/jpeg, image/png" placeholder="<?= $user["pp"] ? $user["pp"] : 'Select file' ?>">
          </div>

          <hr width="80%" align="center">

          <div class="mb-3">
            <div style="display:flex; justify-content: space-between">
              <div class="form-group border-span">
                <select class="form-control" name="permis_class" style="width:33vw;max-width: 350px;<?=$user['permis_class'] ? '' : 'border: 1px solid orange;'?>">
                  <option selected>...</option>
                  <option value="A1">A1</option>
                  <option value="A2">A2</option>
                  <option value="A">A</option>
                </select>
                <?=$user["permis_class"] ? '<span>Type de permis</span>' :''?>
              </div>

              <div class="custom-file" style="width:40vw;">
                <label class="custom-file-label" style="<?=$user['permis_img'] ? '' : 'border: 1px solid orange;'?>" for="inputGroupFile01">Photo du permis</label>
                <input type="file" class="custom-file-input" name="permis_img" accept="image/jpeg, image/png" placeholder="<?= $user["permis_img"] ? $user["permis_img"] : 'Select file' ?>">
              </div>
            </div>
          </div>

          <div>
            <?= $user["permis_img"] ? "<h3>Permis actuel:</h3><img style='width: 200px' src='uploads/photos_profils/".$user["permis_img"]."'>" : ''  ?>
          </div>
          <br>

          <div class="mb-3">
            <input class="btn btn-primary" id="btn" type="submit" value="Modifier">
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
