<?php
// Afficher le parametre GET message si il existe et qu'il n'est pas vide
if(isset($_GET['message']) && !empty($_GET['message']) && isset($_GET['type']) && !empty($_GET['type'])){
  echo '<p class="alert alert-'.$_GET['type'].'" role="alert">' . htmlspecialchars($_GET['message']) . '</p>';
}
?>
