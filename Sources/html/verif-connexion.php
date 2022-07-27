<?php

// Récupérer et traiter les données envoyées par le formulaire via la méthode post

//$_POST['email']
//$_POST['password']

if(isset($_POST['email']) && !empty($_POST['email'])){
	// Créer un cookie qui expire dans une heure
	/*setcookie('email', $_POST['email'], time() + 3600);*/
}

if( !isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['password']) || empty($_POST['password']) ){
	// Rediriger vers connexion.php avec un message d'erreur
	header('location: inscription.php?message=Vous devez remplir les 2 champs.');
	exit;
}

// Ecrire une ligne dans le fichier log.txt

// Ouvrir le fichier ou le créer si besoin
$log = fopen('log.txt', 'a+');

// Création de la ligne à ajouter au log
$line = date("Y/m/d - H:i:s") . ' - Tentative de connexion de : ' . $_POST['email'] . "\n";

fputs($log, $line);

fclose($log);




// Vérifier la validité de l'email

if( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
	// Rediriger vers connexion.php avec un message d'erreur
	header('location: inscription.php?message=Email invalide.');
	exit;
}

//Vérifier la présence de l'utilisateur dans la base de données

//Connexion à la base de données
include('includes/db_connexion.php');




//Requête
$q = 'SELECT id FROM users WHERE email = :email AND password = :password';
//Préparation
$req = $db->prepare($q);
//Exécution
$reponse = $req->execute([
	'email' => $_POST['email'],
	'password' => hash('sha512',$_POST['password']) //Même algo qu'à la création du compte
]);
//Récpérer la première ligne de résultat
$resultat = $req->fetch();

if($resultat){

 if (isset($_POST['remember']) && !empty($_POST['remember'])){

		if ($_POST['remember'] == 'checking') {

		// setcookie('email',$_POST['email'], time() + 365 *24 * 3600, '/', 'hjq-motors.fr', true, true );
		setcookie('email',$_POST['email'], time() + 365 *24 * 3600);
// racine =  accessible partout
// localhost = DNS
// envoyer en sécurité
// http only , cookie pas editable en js
	}
}


	// Créer une session utilisateur
	session_start();

	// Ajouter un paramètre email à la session
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['id'] = $resultat[0];

	// Redirection vers l'accueil
	header('location: index.php');
	exit;
} else {
	// Rediriger vers connexion.php avec un message d'erreur
	header('location: inscription.php?message=Identifiants invalides.');
	exit;
}

?>
