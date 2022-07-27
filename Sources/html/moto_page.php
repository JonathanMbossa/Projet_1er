<?php session_start()?>
<!DOCTYPE html>
<html>
	<head>
		<title>page achat</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"crossorigin="anonymous">
		<link rel="stylesheet" href="css\style_moto.css">
	</head>
	<body>

		<main>
			<?php
			include("includes/db_connexion.php");

			 $q = 'SELECT * FROM moto WHERE id = ?';
			 $req = $db->prepare($q);
			 $req->execute([$_GET["id"]]);
			 $moto = $req->fetch();
			?>
			<div class="container">
				<img class="img-fluid" src="uploads/motos/<?= $moto["banniere"]?>">
				<div class="row">
					<h1 id="titre"><?= $moto["marque"]?> <?= $moto["model"]?></h1>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div>
							<h5>Description</h5>
							<p id="texte"><?= $moto["description"]?></p>
						</div>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div>
							<h5>Documents à presenter en agence:</h5>
						</div>
						<div>
							<p>
								- Permis- Pièce d'identité
								<br>
								- Justificatif de domicile de moins de 3 mois
								<br>
								- Carte bancaire au nom du locataire pour l'empreinte bancaire de 1500€
							</p>
						</div>
						<div>
							<h5>CONDITIONS DE LOCATION:</h5>
							<div>
								<p>
									- Age minimum: <?= $moto["age_min"]?> ans
								</br>
									- Permis de classe <?= $moto["permis_req"]?> ou plus
								</p>
							</div>
						</div>
					</div>

					<h2>Prix de la location: <?= $moto["prix"]?>€/jour</h2>

					<div id="formulaire">
						<h3>Reservation</h3>

						<?php
						if(isset($_SESSION['id'])){
							echo '<form action="verif-reservation.php?moto='.$moto["id"].'" method="post">
											<div class="form-group">
												<label >Début de réservation</label>
												<input type="date" name="dateFrom" class="form-control">
											</div>
											<br>
											<div class="form-group">
												<label >Fin de reservation</label>
												<input type="date" name="dateTo" class="form-control">
											</div>
											<input type="submit" id="res" class="btn btn-secondary" value="RESERVER">
										</form>';
						} else {
							echo '<h3>Vous devez être connecter pour pouvoir réserver</h3>
										<a href="inscription.php"><button id="res" class="btn btn-secondary">Page de connexion ici</button></a>';
						}
						?>
					</div>
				</div>
			</div>
			<div class="parallax" style="background-image: url('uploads/motos/<?=$moto['marque']?>.png')"></div>
		</main>
	</body>
</html>
