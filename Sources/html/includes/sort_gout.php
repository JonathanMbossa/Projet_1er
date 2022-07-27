<?php
  $q = 'SELECT COUNT(*) FROM event WHERE type = ?';
  $req_count = $db->prepare($q);
  $req_count->execute([$sort]);
  $count = $req_count->fetch();
?>
