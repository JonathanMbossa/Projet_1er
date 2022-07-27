<!DOCTYPE html>
<html>
  <head>
    <title>Carte</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php include('../includes/backoffice-header.php'); ?>
    <main>
      <div class='container'>
        <form method="post" class="mb-4">
          <div class="d-flex justify-content-center flex-wrap">
            <select class="form-select mb-3" name="coordonnee">
              <option selected>
                <?php
                  if(isset($_GET['id']) && !empty($_GET['id'])){
                    $req_select = $db->query('SELECT users.firstname, users.lastname, reservation.id FROM reservation,users WHERE reservation.id_user = users.id AND reservation.id = '.$_GET["id"]);
                    $select = $req_select->fetch(PDO::FETCH_ASSOC);
                    if($select){
                      echo 'Reservation n°'.$select["id"].' -- '.$select["firstname"].' ' .$select["lastname"];
                    } else {
                      echo '...';
                    }
                  } else {
                    echo '...';
                  }

                ?>
              </option>
              <?php
              include("../includes/db_connexion.php");

              $sort = "reservation";
              include('../includes/sort.php');

              if($req_min['_min'] && $req_max['_max']){
                for ($i = $req_min['_min']; $i <= $req_max['_max']; $i++){
                  $req_select = $db->query('SELECT users.firstname, users.lastname, reservation.id FROM reservation,users WHERE reservation.id_user = users.id AND reservation.id = '.$i);
                  $select = $req_select->fetch(PDO::FETCH_ASSOC);
                  if($select && $i != $_GET['id']){ //vérifie que la ligne existe bien dans la table
                    echo '<option value="'.$select["id"].'"> Reservation n°'.$select["id"].' -- '.$select["firstname"].' ' .$select["lastname"].'</option>';
                  }
                }
              } else {
                echo '<option>Vide</option>';
              }
              ?>
            </select>
            <input class="btn btn-primary col-4" type="submit">
          </div>
        </form>
        <a href='add_location.php'><button class='btn btn-secondary'>Ajouter une location (test)</button></a>

        <?php
            if(isset($_POST["coordonnee"]) && !empty($_POST["coordonnee"])){
              $req_verif = $db->query('SELECT lat FROM locater WHERE id_reservation = '.$_POST["coordonnee"]);
              $verif = $req_verif->fetch();
              if($verif){
                $req_select = $db->query('SELECT lat,lon FROM locater WHERE id_reservation = '.$_POST["coordonnee"].' AND date_ping = (SELECT MAX(date_ping) FROM locater)');
                $select = $req_select->fetch();
                header('location: carte.php?lat='.$select['lat'].'&lon='.$select['lon'].'&id='.$_POST["coordonnee"]);
              }
            }

            if(isset($_GET["lat"]) && !empty($_GET["lat"]) && isset($_GET["lon"]) && !empty($_GET["lon"])){
              $latitude = $_GET["lat"];
              $longitude = $_GET["lon"];
              echo '<iframe width="100%" height="500" src="https://maps.google.com/maps?q='.$latitude.','.$longitude.'&output=embed"></iframe>';
            } else {
              echo '<h1 class="text-center">Aucune position enregistrer</h1>';
            }
        ?>
        <div class="mt-3">
          <h2 class="text-center">Historique</h2>
          <table class='table table-striped'>
  					<tr>
  					   <th scope='col' class="text-center"> Coordonées </th>
               <th scope='col' class="text-center"> Date </th>
            </tr>
            <?php
              if(isset($_GET['id']) && !empty($_GET['id'])){
                $s = 'SELECT MAX(locater_count) FROM locater WHERE id_reservation = ?';
                $req_select = $db->prepare($s);
                $req_select->execute([$_GET['id']]);
                $max_count = $req_select->fetch();
                if($max_count[0] >= 0){
                  for($i = $max_count[0]; $i >= 0; $i--){
                    $s = 'SELECT lat,lon, date_ping FROM locater WHERE locater_count = :locater_count AND id_reservation = :id_reservation';
                    $req_select = $db->prepare($s);
                    $req_select->execute([
                      'locater_count' => $i,
                      'id_reservation' => $_GET['id']
                    ]);
                    $select = $req_select->fetch();
                    if($select){
                      $date = date_create($select["date_ping"]);
                      echo '<tr>
                              <td scope="row" class="text-center"><a href="carte.php?lat='.$select['lat'].'&lon='.$select['lon'].'&id='.$_GET['id'].'">'.$select["lat"].'       '.$select["lon"].'</a></td>
                              <td scope="row" class="text-center"><a href="carte.php?lat='.$select['lat'].'&lon='.$select['lon'].'&id='.$_GET['id'].'">'.date_format($date,'H:i:s d/m/Y').'</a></td>
                            </tr>';
                    }
                  }
                }
              }
            ?>


        </div>
      </div>
    </main>
  </body>
</html>
