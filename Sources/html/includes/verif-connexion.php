<?php
if(!$_SESSION["id"]){
  // si n'est pas admin, redirige vers l'index
  header('location index.php');
  session_destroy();
  exit;
}
?>
