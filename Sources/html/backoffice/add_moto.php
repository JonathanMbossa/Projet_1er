<!DOCTYPE html>
<html>
	<head>
		<title>Ajouter une moto</title>
		<meta charset="utf-8">
	</head>
	<body>

		<?php include('../includes/backoffice-header.php'); ?>
		<main>
			<div class="container">
				<div class="col-md-12 col-sm-8" id="add_form">
					<form action="verif-add_moto.php" method="post" enctype="multipart/form-data">

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
							<div class="form-floating">
								<input class="form-control" type="number" name="puissance" placeholder=".">
								<label>Puissance (en CC)</label>
							</div>
						</div>

						<div class="mb-3">
							<select class="form-select" name="permis_requis">
								<option selected>Permis requis</option>
								<option value="A">A</option>
								<option value="A1">A1</option>
								<option value="A2">A2</option>
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
								<input class="form-control" type="number" name="age_min" placeholder=".">
								<label>Age minimum</label>
							</div>
						</div>

						<div class="mb-3">
							<div class="form-floating">
								<input class="form-control" type="number" name="prix" placeholder=".">
								<label>Prix à la journée</label>
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

		<!-- <?php include('includes/footer.php'); ?> -->

	</body>
</html>
