<?php
session_start();

//condition incomplete
if( !isset($_POST['marque']) || empty($_POST['marque']) || !isset($_POST['model']) || empty($_POST['model']) || !isset($_POST['puissance']) || empty($_POST['puissance']) || !isset($_POST['permis_requis']) || empty($_POST['permis_requis']) ){
	// Rediriger vers add_moto.php avec un message d'erreur
	header('location: add_moto.php?message=Vous devez remplir tous les champs.');
	exit;
}

// Vérifier si fichier envoyé
if(isset($_FILES['image1']) && !empty($_FILES['image1']['name'])){

		// Vérifier le type de fichier
		$acceptable = [
			'image/jpeg',
			'image/png'
		];

		if(!in_array($_FILES['image1']['type'], $acceptable)){
			// Rediriger vers add_moto.php avec un message d'erreur
			header('location: add_moto.php?message=Type de fichier incorrect.');
			exit;
		}



		// Vérifier le poids du fichier
		$maxSize = 2 * 1024 * 1024;  //2Mo

		if($_FILES['image1']['size'] > $maxSize){
			// Rediriger vers add_moto.php avec un message d'erreur
			header('location: add_moto.php?message=Ce fichier est trop lourd.');
			exit;
		}


		// Enregistrer le fichier sur le serveur
		// Chemin d'enregistrement
		$path = '../uploads/motos';

		// Vérifier que le dossier uploads existe, sinon le créer
		if(!file_exists($path)){
			mkdir($path, 0777);
		}

		$filename1 = $_FILES['image1']['name'];

		//Récupérer l'extentiondu Fichier
		// $ext
		$exte1 = explode('.',$filename1);
		$ext1 = end($exte1);
		$filename1 = $_POST['marque'] . '-' . $_POST['model'].'-1.'.$ext1;

		// Déplacer le fichier vers son emplacement définitif (le dossier uploads)
		$destination = $path . '/' . $filename1;
		move_uploaded_file($_FILES['image1']['tmp_name'], $destination);

		// Vérif le format de l'image
		$size  = getimagesize($destination);
		if($size[0]%600 ||  $size[1]%360){
			// Rediriger vers add_moto.php avec un message d'erreur
			header('location: add_moto.php?message=l\'image doit être au format 16:9');
			unlink($destination);
			exit;
		}

}
// Même opération mais pour la bannière
if(isset($_FILES['image2']) && !empty($_FILES['image2']['name'])){
		if(!in_array($_FILES['image2']['type'], $acceptable)){
			header('location: add_equipement.php?message=Type de fichier incorrect.');
			exit;
		}
		if($_FILES['image2']['size'] > $maxSize){
			header('location: add_equipement.php?message=Ce fichier est trop lourd.');
			exit;
		}

		$filename2 = $_FILES['image2']['name'];

		//Récupérer l'extentiondu Fichier
		// $ext
		$exte2 = explode('.',$filename2);
		$ext2 = end($exte2);
		$filename2 = $_POST['marque'] . '-' . $_POST['model'].'-banniere.'.$ext2;

		// Déplacer le fichier vers son emplacement définitif (le dossier uploads)
		$destination = $path . '/' . $filename2;
		move_uploaded_file($_FILES['image2']['tmp_name'], $destination);

		// Vérif le format de l'image
		$size  = getimagesize($destination);
		if($size[0] < 1120 ||  $size[1] < 400){
			// Rediriger vers add_moto.php avec un message d'erreur
			header('location: add_moto.php?message=l\'image doit être au format 16:9');
			unlink($destination);
			exit;
		}

}

include("../includes/db_connexion.php");

//Vérifier que le model n'est pas déjà présent
$q = 'SELECT id FROM moto WHERE model = :model';
//Préparer la reqête
$req = $db->prepare($q);
//Executer la requête
$req->execute([
	'model' => $_POST['model']
]);
//Récupérer la première ligne de résultat
$reponse = $req ->fetch(); //Renvoie la première ligne sous forme de tableau ou nue valeur bool FALSE
//Si cette ligne existe: erreur, l'email est déjà utilisé
if($reponse){
	// Rediriger vers la page d'accueil
	header('location: add_moto.php?message=Modèle déjà présent');
	exit;
}

// format de date et heure
$dateTime = date('Y-m-d-h-i-s');

//Insérer une nouvelle moto
$q = 'INSERT INTO moto (marque, model,puissance,permis_req,image1,banniere,add_date,add_admin,description,age_min,prix) VALUES (:marque, :model,:puissance,:permis_req,:image1,:banniere,:add_date,:add_admin,:description,:age_min,:prix)';
$req = $db->prepare($q);
$reponse = $req->execute([
	'marque' => $_POST['marque'],
	'model' => $_POST['model'],
	'puissance' => $_POST['puissance'],
	'permis_req' => $_POST['permis_requis'],
	'image1' => isset($filename1) ? $filename1 : '',
	'banniere' => isset($filename2) ? $filename2 : '',
	'add_date' => $dateTime,
	'add_admin' => $_SESSION['id'],
	'description' => $_POST['description'],
	'age_min' => $_POST['age_min'],
	'prix' => $_POST['prix']
]);


if($reponse){
	// Ecrire une ligne dans le fichier log_admin.txt
	// Ouvrir le fichier ou le créer si besoin
	$log = fopen('log_admin.txt', 'a+');
	// Création de la ligne à ajouter au log
	$line = date("Y/m/d - H:i:s") . ' - AJOUT MOTO: '. $_POST['marque'] . ' -- ' .$_POST['model']. ' -- par ' . "\n";
	fputs($log, $line);
	fclose($log);
	// Afficher message de réussite
	header('location: add_moto.php?message=Moto ajouter avec succès');
	exit;
}else{
	// Rediriger vers add_moto.php avec un message d'erreur
	header('location: add_moto.php?message=Erreur lors de l\'ajout.');
	exit;
}

?>
