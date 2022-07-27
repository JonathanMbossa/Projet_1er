<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Signalé un message</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"crossorigin="anonymous">
		<link rel="stylesheet" href="css/stylee.css">
	</head>
	<body></body>
</html>

<?php

//Connexion à la base de données
include('includes/db_connexion.php');


$q = $db->query('SELECT * FROM chat ORDER BY id ASC LIMIT 0, 20 ');
$req = $q->fetchAll();

for ($i = count($req) - 1;$i >= 0;--$i)
{
    $signal = $req[$i];

?><div class="card bg-light mb-3 mb-3 dropdown-menu border-dark" style="margin:10px 10px 10px 10px; padding: 10px;">
	 <br> <?=$signal['email']?>  a était signalé car : <br> <?=$signal['message_signal'] ?>
	 <div style="margin-left: 50vw;>
  <a href="delete_user.php?email=<?=$signal['email'] ?>"><input  type="submit"   class="btn btn-danger"  name="Supprimé" value="Supprimé"></a><br>
	</div>
</div>

 <?php } ?>
