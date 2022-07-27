<?php
// Connexion à la base de données
include("../includes/db_connexion.php");
// session_start();
include("../includes/backoffice-verif_acces.php");

if(!isset($_GET["type"]) || empty($_GET["type"]) || !isset($_GET["id"]) || empty($_GET["id"])){
  header('location: backoffice-index.php');
  exit;
}

$req_verif = $db->prepare('SELECT * FROM '.$_GET["type"].' WHERE id = ?');
$req_verif->execute([$_GET["id"]]);
$verif = $req_verif->fetch();

if( isset($_POST['marque']) && !empty($_POST['marque']) && $_POST['marque'] != $verif['marque'] ){
  // Si titre changer, mettre à jours les informations
  $q = 'UPDATE '.$_GET["type"].' SET marque = ? WHERE id = '.$_GET["id"];
  $req = $db->prepare($q);
  $reponse = $req->execute([$_POST['marque']]);

  if(!$reponse){
  	// Afficher message si erreur
    header('location: backoffice-db_'.$_GET["type"].'.php?message=Erreur lors de la modification.');
  	exit;
  }
}

if( isset($_POST['model']) && !empty($_POST['model']) && $_POST['model'] != $verif['model'] ){
  // Si titre changer, mettre à jours les informations
  $q = 'UPDATE '.$_GET["type"].' SET model = ? WHERE id = '.$_GET["id"];
  $req = $db->prepare($q);
  $reponse = $req->execute([$_POST['model']]);

  if(!$reponse){
  	// Afficher message si erreur
    header('location: backoffice-db_'.$_GET["type"].'.php?message=Erreur lors de la modification.');
  	exit;
  }
}

if( isset($_POST['description']) && !empty($_POST['description']) && $_POST['description'] != $verif['description'] ){
  // Si titre changer, mettre à jours les informations
  $q = 'UPDATE '.$_GET["type"].' SET description = ? WHERE id = '.$_GET["id"];
  $req = $db->prepare($q);
  $reponse = $req->execute([$_POST['description']]);

  if(!$reponse){
  	// Afficher message si erreur
    header('location: backoffice-db_'.$_GET["type"].'.php?message=Erreur lors de la modification.');
  	exit;
  }
}

if( isset($_POST['prix']) && !empty($_POST['prix']) && $_POST['prix'] != $verif['prix'] ){
  // Si titre changer, mettre à jours les informations
  $q = 'UPDATE '.$_GET["type"].' SET prix = ? WHERE id = '.$_GET["id"];
  $req = $db->prepare($q);
  $reponse = $req->execute([$_POST['prix']]);

  if(!$reponse){
  	// Afficher message si erreur
    header('location: backoffice-db_'.$_GET["type"].'.php?message=Erreur lors de la modification.');
  	exit;
  }
}



//========PHOTO==========//
// Type de d'image acceptable
$acceptable = [
  'image/jpeg',
  'image/png'
];

$path = '../uploads/'.$_GET["type"].'s';
// header("location: index.php?message=".$path);
// exit;
// Vérifier que le dossier uploads existe, sinon le créer
if(!file_exists($path)){
  mkdir($path, 0777);
}

// Poids max du fichier
$maxSize = 2 * 1024 * 1024;  //2Mo

if(isset($_FILES['image1']) && !empty($_FILES['image1']['name'])){
  if(!in_array($_FILES['image1']['type'], $acceptable)){
    // Rediriger vers inscription.php avec un message d'erreur
    header('location: backoffice-db_'.$_GET["type"].'.php?message=Erreur lors de la modification.');
    exit;
  }

  if($_FILES['image1']['size'] > $maxSize){
    // Rediriger vers inscription.php avec un message d'erreur
    header('location: backoffice-db_'.$_GET["type"].'.php?message=Erreur lors de la modification.');
    exit;
  }

  if(isset($element['image1'])){
    unlink($path.'/'.$element['image1']).'.*';
  }

  $filename = $_FILES['image1']['name'];

  //Récupérer l'extentiondu Fichier
  // $ext
  $modele = str_replace(' ','',$_POST['model']); //enleve tout les espaces
  $exte = explode('.',$filename);
  $ext = end($exte);
  $filename = $_POST['marque'] . '-' . $modele.'-1.'.$ext;
  // $filename = 'test.'.$ext;
  // Déplacer le fichier vers son emplacement définitif (le dossier uploads)
  $destination = $path . '/' . $filename;
  move_uploaded_file($_FILES['image1']['tmp_name'], $destination);

  $q = 'UPDATE '.$_GET["type"].' SET image1 = (:image1) WHERE id = '.$_GET["id"];
  $req = $db->prepare($q);
  $reponse = $req->execute([
  'image1' => $filename
  ]);

  if(!$reponse){
    // Afficher message si erreur
    header('location: backoffice-db_'.$_GET["type"].'.php?message=Erreur lors de la modification.');
    exit;
  }
}


// PARTIE SPECIFIQUE A L'EQUIPEMENT
if($_GET["type"] == "equipement"){

  if( isset($_POST['type']) && !empty($_POST['type']) && $_POST['type'] != $verif['type'] ){
    // Si titre changer, mettre à jours les informations
    $q = 'UPDATE '.$_GET["type"].' SET type = ? WHERE id = '.$_GET["id"];
    $req = $db->prepare($q);
    $reponse = $req->execute([$_POST['type']]);

    if(!$reponse){
      // Afficher message si erreur
      header('location: backoffice-db_'.$_GET["type"].'.php?message=Erreur lors de la modification.');
      exit;
    }
  }

  if(isset($_FILES['image2']) && !empty($_FILES['image2']['name'])){
    if(!in_array($_FILES['image2']['type'], $acceptable)){
      // Rediriger vers inscription.php avec un message d'erreur
      header('location: backoffice-db_'.$_GET["type"].'.php?message=Erreur lors de la modification.');
      exit;
    }

    if($_FILES['image2']['size'] > $maxSize){
      // Rediriger vers inscription.php avec un message d'erreur
      header('location: backoffice-db_'.$_GET["type"].'.php?message=Erreur lors de la modification.');
      exit;
    }

    if(isset($element['image1'])){
      unlink($path.'/'.$element['image1']).'.*';
    }

    $filename = $_FILES['image2']['name'];

    //Récupérer l'extentiondu Fichier
    // $ext
    $title = str_replace(' ','',$_POST['title']);
    $exte = explode('.',$filename);
    $ext = end($exte);
    $filename = $_POST['marque'] . '-' . $_POST['model'].'-2.'.$ext;

    // Déplacer le fichier vers son emplacement définitif (le dossier uploads)
    $destination = $path . '/' . $filename;
    move_uploaded_file($_FILES['image2']['tmp_name'], $destination);

    $q = 'UPDATE equipement SET image2 = (:imgName) WHERE id = '.$_GET["id"];
    $req = $db->prepare($q);
    $reponse = $req->execute([
    'imgName' => $filename
    ]);

    if(!$reponse){
      // Afficher message si erreur
      header('location: backoffice-db_'.$_GET["type"].'.php?message=Erreur lors de la modification.');
      exit;
    }
  }

}

// PARTIE SPECIFIQUE A MOTO
if($_GET["type"] == "moto"){

  if( isset($_POST['puissance']) && !empty($_POST['puissance']) && $_POST['puissance'] != $verif['puissance'] ){
    // Si titre changer, mettre à jours les informations
    $q = 'UPDATE moto SET puissance = ? WHERE id = '.$_GET["id"];
    $req = $db->prepare($q);
    $reponse = $req->execute([$_POST['puissance']]);

    if(!$reponse){
      // Afficher message si erreur
      header('location: backoffice-db_'.$_GET["type"].'.php?message=Erreur lors de la modification.');
      exit;
    }
  }

  if( isset($_POST['permis_req']) && !empty($_POST['permis_req']) && $_POST['permis_req'] != $verif['permis_req'] ){
    // Si titre changer, mettre à jours les informations
    $q = 'UPDATE moto SET permis_req = ? WHERE id = '.$_GET["id"];
    $req = $db->prepare($q);
    $reponse = $req->execute([$_POST['permis_req']]);

    if(!$reponse){
      // Afficher message si erreur
      header('location: backoffice-db_'.$_GET["type"].'.php?message=Erreur lors de la modification.');
      exit;
    }
  }

  if( isset($_POST['age_min']) && !empty($_POST['age_min']) && $_POST['age_min'] != $verif['age_min'] ){
    // Si titre changer, mettre à jours les informations
    $q = 'UPDATE moto SET age_min = ? WHERE id = '.$_GET["id"];
    $req = $db->prepare($q);
    $reponse = $req->execute([$_POST['age_min']]);

    if(!$reponse){
      // Afficher message si erreur
      header('location: backoffice-db_'.$_GET["type"].'.php?message=Erreur lors de la modification.');
      exit;
    }
  }

}


if($reponse){
  // Ecrire une ligne dans le fichier log_admin.txt
  // Ouvrir le fichier ou le créer si besoin
  $log = fopen('log_admin.txt', 'a+');
  // Création de la ligne à ajouter au log
  $line = date("Y/m/d - H:i:s") . ' - MODIF '.strtoupper($_GET["type"]).': ' . $element['id'] . ' -- '. $_POST['marque'] . ' -- ' .$_POST['model']. ' -- par ' . "\n";
  fputs($log, $line);
  fclose($log);

	// Afficher message de réussite
	header('location: backoffice-db_'.$_GET["type"].'.php?message=Modification effectuer avec succès.');
	exit;
}

header('location: backoffice-db_'.$_GET["type"].'.php');

?>
