<header>
	<nav>
		<ul>
			<li><a href="index.php">Accueil</a></li>
			<?php
				if(isset($_SESSION['email'])){
					echo '<li><a href="deconnexion.php">Déconnexion</a></li>';
					echo '<li><a href="profil.php">Profil</a></li>';

					include("db_connexion.php");
					// Verif si admin
					$q = 'SELECT admin FROM users WHERE email = :email';
					$req = $db->prepare($q);
					$req->execute([
						'email' => $_SESSION['email']
					]);
					$reponse = $req ->fetch();
					if($reponse["admin"]){
						echo '<li><a href="backoffice/backoffice-index.php">Backoffice</a></li>'; // si oui donne accès au back office
					}

				}else{
					echo '<li><a href="inscription.php">Connexion / Inscription </a></li>';
				}
			?>
			<li><a href="equip.php">Catalogue d'équipement</a></li>
			<li><a href="moto.php">Catalogue de motos</a></li>
			<li><a href="chat.php">Chat Publics</a></li>
			<li><a href="event_list.php">Liste des évènements</a></li>
		</ul>
	</nav>
</header>
