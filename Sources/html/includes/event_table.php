<?php
  $sort = "event";
  include("sort.php");
  $y = 0;
  for($i = $req_min["_min"]; $i <= $req_max["_max"]; $i++){
    $t = 'SELECT type FROM event WHERE id = (:id)';
    $req_test = $db->prepare($t); //requête test
    $req_test->execute([
      'id' => $i
    ]);
    $test = $req_test->fetch(); //prend la prmière ligne de la requête
    if($test){ //vérifie que la ligne existe bien dans la table
      $eventSort[$y] = array(
          'id' => $i,
          'type' => $test["type"]
        );
      $y++;
    }
  }
?>
