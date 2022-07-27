<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Modification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  </head>
  <body>
    <?php
      include('../includes/backoffice-header.php');
    ?>
    <main>
      <?php
        include("../includes/db_connexion.php");

        if(!isset($_GET["element"]) || empty($_GET["element"])){
          header('location: backoffice-index.php?message=Merci d\'indiquer un id d\'element');
          exit;
        }

        $q = 'SELECT * FROM '.$_GET["element"].' WHERE id = ?';
        $req = $db->prepare($q);
        $req->execute([$_POST["modif"]]);
        $element = $req->fetch();

        if(!$element){
          header('location: backoffice-db_'.$_GET["element"].'.php?message=Cette element n\'existe pas');
          exit;
        }
      ?>
      <div class="container">
        <div id="modificationInfo" class="mt-5">
          <form action="element_verif-modif.php?type=<?=$_GET["element"]?>&id=<?=$element["id"]?>" method="post" enctype="multipart/form-data">
            <div class="mb-4 mt-3 row justify-content-around">
              <div class="col-5 form-floating">
                <input type="text" class="form-control" name="marque" value="<?=$element["marque"]?>">
                <label>Marque</label>
              </div>
              <div class="col-5 form-floating">
                <input type="text" class="form-control" name="model" value="<?=$element["model"]?>">
                <label>Modèle</label>
              </div>
            </div>

            <?php
              if($_GET["element"] == "equipement"){
                echo '<div class="mb-3">
          							<select class="form-select" name="type">
          							  <option selected>'.$element["type"].'</option>
          							  <option value="casque">Casque</option>
          							  <option value="veste">Veste</option>
          								<option value="gants">Gants</option>
          							  <option value="pantalon">Pantalon</option>
          								<option value="bottes">Bottes</option>
          							</select>
          						</div>';
              } else {
                echo '<div class="mb-3 form-floating">
                        <input type="number" class="form-control" name="puissance" value="'.$element["puissance"].'">
                        <label>Puissance</label>
                      </div>
                      <div class="mb-3">
          							<select class="form-select" name="permis_req">
          								<option selected>'.$element["permis_req"].'</option>
          								<option value="A">A</option>
          								<option value="A1">A1</option>
          								<option value="A2">A2</option>
          							</select>
          						</div>';
              }
            ?>

            <div class="mb-3">
              <label>Description</label>
              <textarea class="form-control" name="description" rows="7"><?=$element["description"]?></textarea>
            </div>

            <?php
              if($_GET["element"] == "moto"){
                echo '<div class="mb-3 form-floating">
                        <input type="number" class="form-control" name="age_min" value="'.$element["age_min"].'">
                        <label>Age minimum</label>
                      </div>';
              }
            ?>

            <div class="mb-5 form-floating">
              <input class="form-control" type="number" name="prix" value="<?=$element['prix']?>">
              <label>Prix</label>
            </div>

            <hr>

            <div class="mb-3">
              <h6 class="form-label text-center">Image<?= $_GET["element"] == "equipement" ? "s" : "" ?></h6>
              <div class="input-group">
                <input type="file" class="form-control" name="image1" id="image" accept="image/jpeg, image/png">
                <?= $_GET["element"] == "equipement" ? '<input type="file" class="form-control" name="image2" id="image">' : '' ?>
              </div>
            </div>

            <input type="submit" class="btn btn-primary form-control mb-3" value="Modifier">
          </form>
        </div>
      </div>
    </main>
  </body>
</html>
