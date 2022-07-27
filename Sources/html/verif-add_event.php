<?php
session_start();

//condition incomplete
if( !isset($_POST['title']) || empty($_POST['title']) || !isset($_POST['description']) || empty($_POST['description']) || !isset($_POST['date_event']) || empty($_POST['date_event']) || $_POST['type'] == "..." ){
	// Rediriger vers inscription.php avec un message d'erreur
	header('location: event_creation.php?message=Vous devez remplir tous les champs.');
	exit;
}

// Ajout des images
// Bon type de fichier
$acceptable = [
  'image/jpeg',
  'image/png'
];
// Taille max du fichier
$maxSize = 2 * 1024 * 1024;  //2Mo

// Chemin d'enregistrement
$path = 'uploads/event';

// Vérifier que le dossier uploads existe, sinon le créer
if(!file_exists($path)){
  mkdir($path, 0777);
}

// Vérifier si fichier envoyé
for($i = 0; $i < 6; $i++){
  if(isset($_FILES['image'.$i]) && !empty($_FILES['image'.$i]['name'])){
  		if(!in_array($_FILES['image'.$i]['type'], $acceptable)){
  			// Rediriger vers inscription.php avec un message d'erreur
  			header('location: event_creation.php?message=Type de fichier incorrect.');
  			exit;
  		}

  		if($_FILES['image'.$i]['size'] > $maxSize){
  			// Rediriger vers inscription.php avec un message d'erreur
  			header('location: event_creation.php?message=Ce fichier est trop lourd.');
  			exit;
  		}

  		$filename[$i] = $_FILES['image'.$i]['name'];

      //Récupérer l'extentiondu Fichier
  		// $ext
  		$exte = explode('.',$filename[$i]);
  		$ext = end($exte);
  		$filename[$i] = $_POST['title']. '-'.$i. '-' . $_POST['date_event'].'.'.$ext;

  		// Déplacer le fichier vers son emplacement définitif (le dossier uploads)
  		$destination = $path . '/' . $filename[$i];
  		move_uploaded_file($_FILES['image'.$i]['tmp_name'], $destination);

  } else {
    $filename[$i] = NULL;
  }
}



// Inscription dans la base de données

// Connexion à la base de données
include("includes/db_connexion.php");

//Vérifier que le model n'est pas déjà présent
$q = 'SELECT id FROM event WHERE title = :title';
//Préparer la reqête
$req = $db->prepare($q);
//Executer la requête
$req->execute([
	'title' => $_POST['title']
]);
//Récupérer la première ligne de résultat
$reponse = $req ->fetch(); //Renvoie la première ligne sous forme de tableau ou nue valeur bool FALSE
//Si cette ligne existe: erreur, l'email est déjà utilisé
if($reponse){
	// Rediriger vers la page d'accueil
	header('location: event_creation.php?message=Un évènement utilise déjà ce titre');
	exit;
}


// Insérer un nouvel event
$p = 'INSERT INTO event (title, id_creater,date_event,description,type,image_0,image_1,image_2,image_3,image_4) VALUES (:title, :id_creater,:date_event,:description,:type,:image_0,:image_1,:image_2,:image_3,:image_4)';
$req = $db->prepare($p);
$reponse = $req->execute([
	'title' => $_POST['title'],
	'id_creater' => $_SESSION['id'],
	'date_event' => $_POST['date_event'],
  'description' => $_POST['description'],
  'type' => $_POST['type'],
	'image_0' => $filename[0],
  'image_1' => $filename[1],
  'image_2' => $filename[2],
  'image_3' => $filename[3],
  'image_4' => $filename[4]
]);


if($reponse){
	// Afficher message de réussite
	header('location: event_creation.php?message=Evenement créer avec succès.');
	exit;
}else{
	// Rediriger vers inscription.php avec un message d'erreur
	header('location: event_creation.php?message=Echec lors de la création de l\'évènement.');
	exit;
}

?>
