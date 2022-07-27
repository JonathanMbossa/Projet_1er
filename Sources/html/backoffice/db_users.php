<!DOCTYPE html>
<html>
	<head>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" href="../css/backoffice-style.css">
		<title>Liste users</title>
	</head>
	<body>
		<?php include('../includes/backoffice-header.php'); ?>
		<main>
			<?php include('../includes/motoMessage.php'); ?>
			<form action="../includes/delete.php?table=users" method="post">
				<div class="mb-3" id="suppr">
					<div class="input-group">
						<div class="form-floating">
							<input class="form-control" id="delete" type="number" name="delete" placeholder="ex: 12">
							<!-- <input type="text" value="event" name="table" style="display: none"> -->
							<label for="floatingSelectGrid">Entrer l'id de la l'event à supprimer</label>
						</div>
						<input class="btn btn-danger input-group-text" type="submit" value="Supprimer">
					</div>
				</div>
			</form>

			<!-- <form action="modif-element.php?element=event" method="post">
				<div class="mb-3" id="modif">
					<div class="input-group">
						<div class="form-floating">
							<input class="form-control" id="delete" type="number" name="modif" placeholder="ex: 12">
							<label for="floatingSelectGrid">Entrer l'id de l'event modifier</label>
						</div>
						<input class="btn btn-primary input-group-text" type="submit" value="Modifier">
					</div>
				</div>
			</form> -->

			<?php
				// Connexion à la base de données
				include("../includes/db_connexion.php");

				echo "<table class='table table-striped'>";
					echo "<tr>";
						echo "<th scope='col'> id </th>";
						echo "<th scope='col'> Prénom </th>";
						echo "<th scope='col'> Nom </th>";
						echo "<th scope='col'> Email </th>";
						echo "<th scope='col'> Téléphone </th>";
            echo "<th scope='col'> Adresse </th>";
            echo "<th scope='col'> Date naissance </th>";
            echo "<th scope='col'> Permis </th>";
						echo "<th scope='col'> Photo permis </th>";
            echo "<th scope='col'> Photo profil </th>";
					echo "</tr>";

				$sort = 'users';
				include('../includes/sort.php');

				if($req_min['_min'] != NULL && $req_max['_max'] != NULL){
				for ($i = $req_min['_min']; $i <= $req_max['_max']; $i++) {
					$req_test = $db->query('SELECT id FROM users WHERE id ='.$i); //requête test
					$test = $req_test->fetch(PDO::FETCH_ASSOC); //prend la prmière ligne de la requête
					if($test != null){ //vérifie que la ligne existe bien dans la table
						$requete = $db->query('SELECT * FROM users WHERE id = '.$i); //Selection de toute la ligne avec l'id de valeur $i
						$req = $requete->fetch();

						echo '<tr>';
						for($y = 0; $y <=5; $y++){
							echo '<td scope="row">' . $req[$y] . '</td>';
						}
						$date = date_create($req["birth_date"]);
              echo '<td scope="row">' . date_format($date,"d/m/Y") . '</td>';
              echo '<td scope="row">' . $req["permis_class"] . '</td>';
							echo '<td scope="row"><img src="../uploads/photos_profils/' . $req["permis_img"] .'"/> </td>';
              echo '<td scope="row"><img src="../uploads/users/' . $req["pp"] .'"/> </td>';
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
