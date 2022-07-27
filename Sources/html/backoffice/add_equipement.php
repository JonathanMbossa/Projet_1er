<!DOCTYPE html>
<html>
	<head>
		<title>Ajouter un équipement</title>
		<meta charset="utf-8">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/backoffice-style.css">
		<style>
			form > div.mb-3 > select {
				height: 58px;
			}
		</style>
	</head>
	<body>

		<? include('../includes/backoffice-header.php'); ?>
		<main>
			<div class="container">
				<div class="col-md-11 col-sm-6" id="add_form">
					<form action="verif-add_equipement.php" method="post" enctype="multipart/form-data">

						<div class="mb-3">
							<div class="form-floating">
								<input class="form-control" type="text" name="marque" placeholder=".">
								<label>Marque</label>
							</div>
						</div>

						<div class="mb-3">
							<div class="form-floating">
								<input class="form-control" type="text" name="model" placeholder=".">
								<label>Modèle</label>
							</div>
						</div>

						<div class="mb-3">
							<select class="form-select" name="type">
							  <option selected>Type d'équipement</option>
							  <option value="casque">Casque</option>
							  <option value="veste">Veste</option>
								<option value="gants">Gants</option>
							  <option value="pantalon">Pantalon</option>
								<option value="bottes">Bottes</option>
							</select>
						</div>

						<div class="mb-3">
							<div class="form-floating">
								<textarea class="form-control" type="text" name="description" rows="5" style="height: 100px;" placeholder="."></textarea>
								<label>Description</label>
							</div>
						</div>

						<div class="mb-3">
							<div class="form-floating">
								<input class="form-control" type="number" name="prix" placeholder=".">
								<label>Prix</label>
							</div>
						</div>

						<hr>

						<div class="mb-3">
							<div class="row">
								<div class="col">
									<input class="form-control" type="file" name="image1" accept="image/jpeg, image/png">
								</div>
								<div class="col">
									<input class="form-control" type="file" name="image2" accept="image/jpeg, image/png">
								</div>
							</div>
						</div>

						<div class="mb-3">
							<input class="btn btn-primary form-control" type="submit">
						</div>
					</form>
				</div>
			</div>
		</main>
	</body>
</html>
