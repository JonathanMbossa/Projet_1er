<?php
  $max = $db->query('SELECT max(id) AS _max FROM ' .$sort); //requête SQL pour connaitre la taille du tableau
  $req_max = $max->fetch(PDO::FETCH_ASSOC); //prend la première ligne renvoyer
  $min = $db->query('SELECT min(id) AS _min FROM ' .$sort); //requête SQL pour connaitre le debut du tableau
  $req_min = $min->fetch(PDO::FETCH_ASSOC); //prend la première ligne renvoyer
?>
