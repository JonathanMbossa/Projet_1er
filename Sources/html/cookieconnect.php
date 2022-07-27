<?


if (!isset($_SESSION['id']) AND isset($_COOKIE['email'],$COOKIE['password']) AND !empty($_COOKIE['email']) AND !empty($_COOKIE['password'])) {
	

	$q = 'SELECT id FROM users WHERE email = :email AND password = :password';
//Préparation 
$req = $db->prepare($q);
//Exécution
$reponse = $req->execute([
	'email' => $_COOKIE['email'],
	'password' => hash('sha512',$_COOKIE['password']) //Même algo qu'à la création du compte
]);

$resultat = $req->fetch();

if($resultat){
	// Créer une session utilisateur
	session_start();

	// Ajouter un paramètre email à la session
	$_SESSION['email'] = $_POST['email'];

	// Redirection vers l'accueil
	header('location: index.php');
	exit;
} else {
	// Rediriger vers connexion.php avec un message d'erreur
	header('location: inscription.php?message=Identifiants invalides.');
	exit;
}

}


?>