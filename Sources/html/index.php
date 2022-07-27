<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Accueil</title>
		<meta charset="utf-8">
	</head>
	<body>

		<?php
			include('includes/header.php');
			// include('includes/ad.php');

		?>
<script data-ad-client="ca-pub-2264052534738127" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<main>

			<?php
			// Afficher le parametre GET message si il existe et qu'il n'est pas vide
			if(isset($_GET['message']) && !empty($_GET['message'])){
				echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
			}
			?>

			<?php
			if(isset($_SESSION['email'])){
				echo '<p>Voici votre contenu privé.</p>';
			}else{
				echo '<p>Contenu non disponible.</p>';
			}
			?>

		</main>

		<?php include('includes/footer.php'); ?>

	</body>
</html>
