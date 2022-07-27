<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css\style.css">
</head>
<body style="margin: 0">
	<video  src="img/Koala.mp4" style="width: 100vw" loop muted autoplay></video>
</body>
</html>


<?php
$message = '<p>Bonjour, Pour valider votre inscription dans la base de données,<a href="http://www.hjq-motors.fr/index.php">veuillez cliquer sur ce lien</a> s\'il vous plait</p>';

ini_set('SMTP','myserver');
ini_set('smtp_port',25);

$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

mail ($_GET['email'] , 'Vérification_inscription', $message, implode("\r\n", $headers));

echo "<p>Salut à toi ".$_GET['email'].". Pour finaliser ton inscription, moi et mon équipe t'avons envoyer un message afin qu'on puisse vérifier ton identité.</p>";

/*if ($success) {
	echo 'Un message vous à étais envoyer';
}else{
	echo 'une erreur c\'est produite';
}*/

?>

						

