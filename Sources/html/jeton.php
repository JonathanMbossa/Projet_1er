<?php

try{
  $db = new PDO('mysql:host=localhost;dbname=HJQ', 'admin', 'ESGI', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
}catch(Exception $e){
  die('Erreur : ' . $e->getMessage()); // Si erreur, afficher le message d'erreur
}


  if (isset($_GET['jeton']) && !empty($_GET['jeton']))
  {
  	$verift = $db->prepare ('SELECT email FROM users WHERE jeton = ?');
  		$verift->execute
  		([

  			$_GET['jeton']


  		]);

  		$email = $verift->fetch();

      $email = $email[0];


  		if (!$email)
  		{

        echo "erreur";
      }
  			?>


  			<!DOCTYPE html>
  			<html>
  			<head>
  				<title>Récupération du mot de passe</title>
  			</head>
  			<body>
  				<form method="post">
  					<label>Nouveau mot de passe : </label>
  					<input type="password" name="newPassword">

  					 <input  type="submit" class="btn btn-outline-success" value="Confirmer"></input>

  				</form>
  			</body>
  			</html>
  			<?php

  }


if (isset($_POST['newPassword']) && !empty($_POST['newPassword']))
{
	$hashedPassword = hash('sha512',$_POST['newPassword']);
	 $change_mdp = "UPDATE users SET password = ? WHERE jeton = ?";
     $change = $db->prepare($change_mdp);
     $change=$change->execute

 	 ([

	     $hashedPassword,
	     $_GET['jeton']

     ]);

     if ($change) {
          echo "Mot de passe modifié avec succés !";
     }
else{
  erreur;
}


}
?>
