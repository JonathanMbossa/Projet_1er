<!DOCTYPE html>
<html>
  <head>
    <title>Tableau de bord</title>
		<meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/backoffice-style.css">
  </head>
  <body>
    <?php include('../includes/db_connexion.php'); ?> <!-- Connexion à la base de données -->
    <?php include('../includes/backoffice-header.php'); ?>
    <main>
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-6" id="lastAddEquip">
            <h1> Derniers équipements ajouter </h1>
              <?php
                $sort = 'equipement';
                include('../includes/sort.php');
                echo "<table class='table table-striped'>";
                if($req_min['_min'] != NULL && $req_max['_max'] != NULL){
                  for ($i = $req_max['_max']; $i >= $req_max['_max']-4; $i--) {
                    $req_test = $db->query('SELECT id FROM equipement WHERE id ='.$i); //requête test pour vérif l'existance
                    $test = $req_test->fetch(PDO::FETCH_ASSOC); //prend la prmière ligne de la requête
                    if($test != null){ //vérifie que la ligne existe bien dans la table
                      $requete = $db->query('SELECT * FROM equipement WHERE id = '.$i); //Selection de toute la ligne avec l'id de valeur $i
                      $req = $requete->fetch();

                      echo '<tr>';
                      for($y = 0; $y <=3; $y++){
                        echo '<td scope="col">' . $req[$y] . '</td>';
                      }
                        echo '<td scope="col">' . $req[$y+1] . '</td>';
                        echo '<td scope="col">' . $req[$y+2] . '</td>';
                      echo '</tr>';
                    }
                  }
                }
                echo "</table>";
            ?>
          </div>

          <div class="col-md-3 col-sm-6" id="lastAddBike">
            <h1> Dernières motos ajouter </h1>
            <?php
              $sort = 'moto';
              include('../includes/sort.php');
              echo "<table class='table table-striped'>";
              if($req_min['_min'] != NULL && $req_max['_max'] != NULL){
                for ($i = $req_max['_max']; $i >= $req_max['_max']-4; $i--) {
                  $req_test = $db->query('SELECT id FROM moto WHERE id ='.$i); //requête test
                  $test = $req_test->fetch(PDO::FETCH_ASSOC); //prend la prmière ligne de la requête
                  if($test != null){ //vérifie que la ligne existe bien dans la table
                    $requete = $db->query('SELECT * FROM moto WHERE id = '.$i); //Selection de toute la ligne avec l'id de valeur $i
                    $req = $requete->fetch();

                    echo '<tr>';
                    for($y = 0; $y <=6; $y++){
                      echo '<td scope="col">' . $req[$y] . '</td>';
                    }
                    echo '</tr>';
                  }
                }
              }
              echo "</table>";
            ?>
          </div>

          <div class="col-md-3 col-sm-6" id="lastAddUser">
            <h1>Derniers utilisateurs enregistrer</h1>
            <?php
              $sort = 'users';
              include('../includes/sort.php');
              echo "<table class='table table-striped'>";
              if($req_min['_min'] != NULL && $req_max['_max'] != NULL){
                for ($i = $req_max['_max']; $i >= $req_max['_max']-4; $i--) {
                  $req_test = $db->query('SELECT id FROM users WHERE id ='.$i); //requête test pour vérif l'existance
                  $test = $req_test->fetch(PDO::FETCH_ASSOC); //prend la prmière ligne de la requête
                  if($test != null){ //vérifie que la ligne existe bien dans la table
                    $requete = $db->query('SELECT * FROM users WHERE id = '.$i); //Selection de toute la ligne avec l'id de valeur $i
                    $req = $requete->fetch();
                    echo '<tr>';
                    for($y = 1; $y <=3; $y++){
                      echo '<td scope="col">' . $req[$y] . '</td>';
                    }
                    echo '</tr>';
                  }
                }
              }
              echo "</table>";
            ?>
          </div>
          <div class="col-md-3 col-sm-6" id="lastAddEvent">
            <h1> Derniers évènements créer</h1>
            <?php
              $sort = 'event';
              include('../includes/sort.php');
              echo "<table class='table table-striped'>";
              if($req_min['_min'] != NULL && $req_max['_max'] != NULL){
                for ($i = $req_max['_max']; $i >= $req_max['_max']-4; $i--) {
                  $req_test = $db->query('SELECT id FROM event WHERE id ='.$i); //requête test pour vérif l'existance
                  $test = $req_test->fetch(PDO::FETCH_ASSOC); //prend la prmière ligne de la requête
                  if($test != null){ //vérifie que la ligne existe bien dans la table
                    $requete = $db->query('SELECT event.title,event.id_creater,event.type,event.date_event,users.firstname, users.lastname FROM users,event WHERE event.id_creater = users.id AND event.id = '.$i); //Selection de toute la ligne avec l'id de valeur $i
                    $req = $requete->fetch();
                    echo '<tr>';
                    $date = date_create($req['date_event']);
                      echo '<td scope="col">' . $req['title'] . '</td>
                            <td scope="col">' . $req['type'] . '</td>
                            <td scope="col">' . date_format($date,"d/m/Y") . '</td>
                            <td scope="col">' . $req['firstname'] . ' ' . $req['lastname'] . '</td>';

                    // for($y = 0; $y <=3; $y++){
                    //   echo '<td scope="col">' . $req[$y] . '</td>';
                    // }
                    echo '</tr>';
                  }
                }
              }
              echo "</table>";
            ?>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
