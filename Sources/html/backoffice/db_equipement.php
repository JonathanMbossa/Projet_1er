<!DOCTYPE html>
<html>
	<head>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" href="../css/backoffice-style.css">
		<title>Liste équipements</title>
		<meta charset="utf-8">
	</head>
	<body>
		<?php include('../includes/backoffice-header.php'); ?>
		<main>

			<div class="text-center">
				<a href="add_equipement.php"><button class="mb-4 mt-2 btn btn-primary">Ajouter un équipement</button></a>
			</div>

			<?php include('../includes/motoMessage.php'); ?>

			<form action="../includes/delete.php?table=equipement" method="post">
				<div class="mb-3" id="suppr">
					<div class="input-group">
						<div class="form-floating">
							<input class="form-control" id="delete" type="number" name="delete" placeholder="ex: 12">
							<!-- <input type="text" value="equipement" name="table" style="display: none"> -->
							<label for="floatingSelectGrid">Entrer l'id de l'équipement à supprimer</label>
						</div>
						<input class="btn btn-danger input-group-text" type="submit" value="Supprimer">
					</div>
				</div>
			</form>

			<form action="modif-element.php?element=equipement" method="post">
				<div class="mb-3" id="modif">
					<div class="input-group">
						<div class="form-floating">
							<input class="form-control" id="delete" type="number" name="modif" placeholder="ex: 12">
							<input type="text" value="equipement" name="table" style="display: none">
							<label for="floatingSelectGrid">Entrer l'id de l'équipement modifier</label>
						</div>
						<input class="btn btn-primary input-group-text" type="submit" value="Modifier">
					</div>
				</div>
			</form>

			<?php
				// Connexion à la base de données
				include('../includes/db_connexion.php');

				echo "<table class='table table-striped'>
								<tr>
									<th scope='col'> id </th>
									<th scope='col'> Type d'équipement </th>
									<th scope='col'> Marque </th>
									<th scope='col'> Modèle </th>
									<th scope='col'> Description </th>
									<th scope='col'> Prix </th>
									<th scope='col'> Ajout </th>
									<th scope='col'> Image 1 </th>
									<th scope='col'> Image 2 </th>
								</tr>";

				$sort = 'equipement';
				include('../includes/sort.php');

				if($req_min['_min'] != NULL && $req_max['_max'] != NULL){
				for ($i = $req_min['_min']; $i <= $req_max['_max']; $i++) {
					$req_test = $db->query('SELECT id FROM equipement WHERE id ='.$i); //requête test
					$test = $req_test->fetch(PDO::FETCH_ASSOC); //prend la prmière ligne de la requête
					if($test != null){ //vérifie que la ligne existe bien dans la table
						$requete = $db->query('SELECT * FROM equipement WHERE id = '.$i); //Selection de toute la ligne avec l'id de valeur $i
						$req = $requete->fetch();

						echo '<tr>';
						for($y = 0; $y <=5; $y++){
							echo '<td  scope="row"><a id="redirect" target="_blank" href="../equipement_page.php?equipement='.$req["id"].'"> '. $req[$y] .'</a></td>';
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

							echo '<td scope="row"><img src="../uploads/equipements/' . $req[8] .'"/> </td>';
							echo '<td scope="row"><img src="../uploads/equipements/' . $req[9] .'"/> </td>';
						echo '</tr>';

					}
				}
				echo "</table>";
			} else{
				echo "<h1>table vide</h1>";
			}
			?>
		</main>
	<body>
</html>
