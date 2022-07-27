<?php

//condition incomplete
if( !isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['password']) || empty($_POST['password']) || !isset($_POST['adresse']) || empty($_POST['adresse']) || !isset($_POST['tel']) || empty($_POST['tel']) ){
	// Rediriger vers inscription.php avec un message d'erreur
	header('location: inscription.php?message=Vous devez remplir tous les champs.');
	exit;
}

if( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
	// Rediriger vers inscription.php avec un message d'erreur
	header('location: inscription.php?message=Email invalide.');
	exit;
}

// Vérifier si fichier envoyé
if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){

		// Vérifier le type de fichier
		$acceptable = [
			'image/jpeg',
			'image/png'
		];

		if(!in_array($_FILES['image']['type'], $acceptable)){
			// Rediriger vers inscription.php avec un message d'erreur
			header('location: inscription.php?message=Type de fichier incorrect.');
			exit;
		}


		// Vérifier le poids du fichier
		$maxSize = 2 * 1024 * 1024;  //2Mo

		if($_FILES['image']['size'] > $maxSize){
			// Rediriger vers inscription.php avec un message d'erreur
			header('location: inscription.php?message=Ce fichier est trop lourd.');
			exit;
		}


		// Enregistrer le fichier sur le serveur


		// Chemin d'enregistrement
		$path_permis = 'uploads/permis';

		// Vérifier que le dossier uploads existe, sinon le créer
		if(!file_exists($path_permis)){
			mkdir($path_permis, 0777);
		}

		$filename = $_FILES['image']['name'];

		// Déplacer le fichier vers son emplacement définitif (le dossier uploads)
		$destination = $path_permis . '/' . $_FILES['image']['name'];
		move_uploaded_file($_FILES['image']['tmp_name'], $destination);


}


// Inscription dans la base de données

// Connexion à la base de données
include("includes/db_connexion.php");

//Vérifier que le model n'est pas déjà présent
$q = 'SELECT id FROM users WHERE email = :email';
//Préparer la reqête
$req = $db->prepare($q);
//Executer la requête
$req->execute([
	'email' => $_POST['email']
]);
//Récupérer la première ligne de résultat
$reponse = $req ->fetch(); //Renvoie la première ligne sous forme de tableau ou nue valeur bool FALSE
//Si cette ligne existe: erreur, l'email est déjà utilisé
if($reponse){
	// Rediriger vers la page d'accueil
	header('location: inscription.php?message=Utilisateur déjà présent');
	exit;
}


// Insérer un nouvel utilisateur
$q = 'INSERT INTO users (email, password,adresse,tel,permis_img,permis_class) VALUES (:email, :password,:adresse,:tel,:permis_img,:permis_class)';
$req = $db->prepare($q);
$reponse = $req->execute([
	'email' => $_POST['email'],
	'password' => hash('sha512',$_POST['password']),
	'adresse' => $_POST['adresse'],
  'tel' => $_POST['tel'],
  'permis_img' => isset($filename) ? $filename : '',
	'permis_class' => $_POST['permis_class']
]);


if($reponse){
	// Afficher message de réussite
	header('location: envoimail.php?message=Inscription réussite&email='.$_POST['email'] );
	exit;
}else{
	// Rediriger vers inscription.php avec un message d'erreur
	header('location: inscription.php?message=Erreur lors de l\'inscription.');
	exit;
}

?>
