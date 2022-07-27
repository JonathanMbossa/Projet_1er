<?php
// Connexion à la base de données
include("includes/db_connexion.php");
session_start();

$req_verif = $db->prepare('SELECT * FROM event WHERE id = ?');
$req_verif->execute([$_SESSION["id"]]);
$verif = $req_verif->fetch();

if( isset($_POST['title']) && !empty($_POST['title']) && $_POST['title'] != $verif['title'] ){
  // Si titre changer, mettre à jours les informations
  $q = 'UPDATE event SET title = ? WHERE id = '.$_GET["id"];
  $req = $db->prepare($q);
  $reponse = $req->execute([$_POST['title']]);

  if(!$reponse){
  	// Afficher message si erreur
    header('location: event_gestion.php?id='.$_GET["id"].'?message=Erreur lors de la modification.');
  	exit;
  }
}

if( isset($_POST['type']) && !empty($_POST['type']) && $_POST['type'] != $verif['type'] ){
  // Si type changer, mettre à jours les informations
  $q = 'UPDATE event SET type = ? WHERE id = '.$_GET["id"];
  $req = $db->prepare($q);
  $reponse = $req->execute([$_POST['type']]);

  if(!$reponse){
  	// Afficher message si erreur
    header('location: event_gestion.php?id='.$_GET["id"].'?message=Erreur lors de l\'inscription.');
  	exit;
  }
}

if( isset($_POST['date_event']) && !empty($_POST['date_event']) && $_POST['date_event'] != $verif['date_event'] ){
  // Si date changer, mettre à jours les informations
  $q = 'UPDATE event SET date_event = ? WHERE id = '.$_GET["id"];
  $req = $db->prepare($q);
  $reponse = $req->execute([$_POST['date_event']]);

  if(!$reponse){
  	// Afficher message si erreur
    header('location: event_gestion.php?id='.$_GET["id"].'?message=Erreur lors de la modification.');
  	exit;
  }
}

if( isset($_POST['description']) && !empty($_POST['description']) && $_POST['description'] != $verif['description'] ){
  // Si Prénom changer, mettre à jours les informations
  $q = 'UPDATE event SET description = ? WHERE id = '.$_GET["id"];
  $req = $db->prepare($q);
  $reponse = $req->execute([$_POST['description']]);

  if(!$reponse){
  	// Afficher message si erreur
    header('location: event_gestion.php?id='.$_GET["id"].'?message=Erreur lors de la modification.');
  	exit;
  }
}


//========PHOTOS==========//

// Type de d'image acceptable
$acceptable = [
  'image/jpeg',
  'image/png'
];

$path = 'uploads/event';
// Vérifier que le dossier uploads existe, sinon le créer
if(!file_exists($path)){
  mkdir($path, 0777);
}

// Poids max du fichier
$maxSize = 2 * 1024 * 1024;  //2Mo

// Vérifier si fichier envoyé
for($i = 0; $i < 5; $i++){
  if(isset($_FILES['image'.$i]) && !empty($_FILES['image'.$i]['name'])){
  		if(!in_array($_FILES['image'.$i]['type'], $acceptable)){
  			// Rediriger vers inscription.php avec un message d'erreur
  			header('location: event_gestion.php?id='.$_GET["id"].'?message=Erreur lors de la modification.');
  			exit;
  		}

  		if($_FILES['image'.$i]['size'] > $maxSize){
  			// Rediriger vers inscription.php avec un message d'erreur
  			header('location: event_gestion.php?id='.$_GET["id"].'?message=Erreur lors de la modification.');
  			exit;
  		}

      if(isset($verif["image".$i])){
        unlink($path.'/'.$verif["image".$i]);
      }

  		$filename = $_FILES['image'.$i]['name'];

      //Récupérer l'extentiondu Fichier
  		// $ext
      $title = str_replace(' ','',$_POST['title']);
  		$exte = explode('.',$filename);
  		$ext = end($exte);
  		$filename = $title. '-'.$i. '-' . $_POST['date_event'].'.'.$ext;

  		// Déplacer le fichier vers son emplacement définitif (le dossier uploads)
  		$destination = $path . '/' . $filename;
  		move_uploaded_file($filename, $destination);

      $imgNum = "image_".$i;

      $q = 'UPDATE event SET '.$imgNum.' = (:imgName) WHERE id = '.$_GET["id"];
      $req = $db->prepare($q);
      $reponse = $req->execute([
        'imgName' => $filename
      ]);

      if(!$reponse){
      	// Afficher message si erreur
        header('location: profil.php?message=Erreur lors de l\'inscription.');
      	exit;
      }
    }
}

if($reponse){
	// Afficher message de réussite
	header('location: event_gestion.php?id='.$_GET["id"].'?message=Modification effectuer avec succès.');
	exit;
}

header('location: event_gestion.php?id='.$_GET["id"]);

?>
