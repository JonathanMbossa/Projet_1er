<!DOCTYPE html>
<html>
	<head>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" href="../css/backoffice-style.css">
		<title>Liste motos</title>
	</head>
	<body>
		<?php include('../includes/backoffice-header.php'); ?>
		<main>
			<?php include('../includes/motoMessage.php'); ?>

			<div class="text-center">
				<a href="add_moto.php"><button class="mb-4 mt-2 btn btn-primary">Ajouter une moto</button></a>
			</div>

			<form action="../includes/delete.php?table=moto" method="post">
				<div class="mb-3" id="suppr">
					<div class="input-group">
						<div class="form-floating">
							<input class="form-control" id="delete" type="number" name="delete" placeholder="ex: 12">
							<!-- <input type="text" value="moto" name="table" style="display: none"> -->
							<label for="floatingSelectGrid">Entrer l'id de la moto à supprimer</label>
						</div>
						<input class="btn btn-danger input-group-text" type="submit" value="Supprimer">
					</div>
				</div>
			</form>

			<form action="modif-element.php?element=moto" method="post">
				<div class="mb-3" id="modif">
					<div class="input-group">
						<div class="form-floating">
							<input class="form-control" id="delete" type="number" name="modif" placeholder="ex: 12">
							<label for="floatingSelectGrid">Entrer l'id de la moto modifier</label>
						</div>
						<input class="btn btn-primary input-group-text" type="submit" value="Modifier">
					</div>
				</div>
			</form>

			<?php
				// Connexion à la base de données
				include("../includes/db_connexion.php");

				echo "<table class='table table-striped'>";
					echo "<tr>";
						echo "<th scope='col'> id </th>";
						echo "<th scope='col'> Marque </th>";
						echo "<th scope='col'> Modèle </th>";
						echo "<th scope='col'> Puissance </th>";
						echo "<th scope='col'> Permis requis </th>";
						echo "<th scope='col'> Description </th>";
						echo "<th scope='col'> Age minimum </th>";
						echo "<th scope='col'> Ajout </th>";
						echo "<th scope='col'> Image </th>";
						// echo "<th scope='col'> Image 2</th>";
					echo "</tr>";

				$sort = 'moto';
				include('../includes/sort.php');

				if($req_min['_min'] != NULL && $req_max['_max'] != NULL){
				for ($i = $req_min['_min']; $i <= $req_max['_max']; $i++) {
					$req_test = $db->query('SELECT id FROM moto WHERE id ='.$i); //requête test
					$test = $req_test->fetch(PDO::FETCH_ASSOC); //prend la prmière ligne de la requête
					if($test != null){ //vérifie que la ligne existe bien dans la table
						$requete = $db->query('SELECT * FROM moto WHERE id = '.$i); //Selection de toute la ligne avec l'id de valeur $i
						$req = $requete->fetch();

						echo '<tr>';
						for($y = 0; $y <=6; $y++){
							echo '<td scope="row"><a href="../moto_page.php?id='.$req["id"].'" target="_blank">' . $req[$y] . '</td>';
						}
						$date = date_create($req["add_date"]);

						// recup le nom de l'admin
						$q = 'SELECT firstname,lastname FROM users WHERE id = :id_admin';
						$req_admin = $db->prepare($q);
						$req_admin->execute([
							'id_admin' => $req["add_admin"]
						]);
						$admin = $req_admin->fetch();
							echo '<td  scope="row"> le '. date_format($date,"d/m/Y") .'  par '.$admin["firstname"].'  '.$admin["lastname"].'</a></td>';

							echo '<td scope="row"><img src="../uploads/motos/' . $req["image1"] .'"/> </td>';
						echo '</tr>';

					}
				}
				echo "</table>";
			} else{
				echo "table vide";
			}
			?>
		</main>
	<body>
</html>
