<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
    crossorigin="anonymous">
      <link rel="stylesheet" href="css/stylee.css">
</head>
<body id="MDP">
<h1 id="MDP2">Mot de passe oublié ?</h1>
<form method="post">


<div class='container'>
  <div id="SCANF">
      <input  type="Email" name="email" class="form-control"  placeholder="Saisissez votre email de récupération">
     <!--  <input type="text" class="form-control" name="email"  placeholder="Saisissez votre email de récupération"> -->
   </div>
 </div>


   <div id="BUTTON">
      <input  type="submit" class="btn btn-outline-success" value="Envoyez moi mon nouveau mot de passe"></input>
  </div>




</form>
</body>
</html>


<?php

  try{
    $db = new PDO('mysql:host=localhost;dbname=HJQ', 'admin', 'ESGI', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  }catch(Exception $e){
    die('Erreur : ' . $e->getMessage()); // Si erreur, afficher le message d'erreur
  }



if (isset($_POST['email']) && !empty($_POST['email']))
 {


$jeton = uniqid(); // génere un mot de passe

// echo $jeton;

$url = 'http://www.hjq-motors.fr/jeton.php?jeton=' . $jeton;
echo $url;


$message = "Bonjour, voici votre lien pour la réinitialisation du mot de passe : $url";




if (mail($_POST['email'], 'Mot de passe oublié', $message)) {
    $change_mdp = "UPDATE users SET jeton = ? WHERE email = ?";
    $change = $db->prepare($change_mdp);
    $change->execute
  ([

     $jeton,
     $_POST['email']

   ]);

  echo "Mail envoyé";

  }

    else

  {

    echo "une erreur est survenue...";

  }

  }


?>
