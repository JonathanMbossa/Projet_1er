<!DOCTYPE html>
<html lang="fr" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Signalé un message</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" href="css/stylee.css">
	</head>
	<body >
		<h1 id="MDP2">Une personne à Signalé ?</h1>
		<form method="post">
			<div class='container'>
				<div id="SCANF">
					<input  type="email" name="email" class="form-control"  placeholder="Saisissez l'email de l'utilisateur à Signalé">
					<textarea name="message_signal"  cols="60" style="margin-top:3em"; placeholder="Pourquoi Signalé-vous cette utilisateur ?"></textarea>
				</div>
			</div>
			<div id="BUTTON">
				<input  type="submit" class="btn btn-outline-success" value="Signalé" name="Signalé">
			</div>
		</form>
		
		<?php

		// phpinfo();
		// die;

		//Connexion à la base de données
		include('includes/db_connexion.php');

		if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['message_signal']) && !empty($_POST['message_signal']) ) {

			$email = htmlspecialchars($_POST['email']);
			$message_signal = htmlspecialchars($_POST['message_signal']); // sécurisation


			$q = "INSERT INTO chat(email,message_signal) VALUES (?, ?)"; // insére les message et l'email
			$req = $db->prepare($q);
			$reponse = $req->execute([
				$email,
				$message_signal
			]);

			if($reponse) {
				header("location: Mreport.php?Merci d'avoir signaler cette utilisateur");
				exit;
			} else {
				header('location: Mreport.php?Utilisateur non Signalé');
				exit;
			}
		}

		?>
	</body>
</html>
