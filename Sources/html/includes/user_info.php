<?php
  $q = 'SELECT * FROM users WHERE email = ?';
  $req = $db->prepare($q);
  $req->execute([
    $_SESSION['email']
  ]);
  $user = $req ->fetch();
?>
