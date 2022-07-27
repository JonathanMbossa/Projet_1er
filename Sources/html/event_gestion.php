<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Gestion de l'évènement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  </head>
  <body>
    <main>
      <?php
        session_start();
        if(!isset($_SESSION["id"]) || empty($_GET['id'])){
          header("location: event_list.php");
          exit;
        }

        include("includes/db_connexion.php");
        $q = 'SELECT * FROM event WHERE id = ?';
        $req = $db->prepare($q);
        $req->execute([$_GET["id"]]);
        $event = $req->fetch();

        $p = 'SELECT COUNT(*) FROM participe WHERE id_event = ?';
        $req_part = $db->prepare($p);
        $req_part->execute([$_GET['id']]);
        $participe = $req_part->fetch();

        $date = date_create($event["date_event"]);

      ?>

      <div class="container">
        <div id="stats" class="text-center mt-3">
          <h5>Vues: <?=$event['nb_view']?></h5>
          <h5>Nombre de participant: <?=$participe[0]?></h5>
        </div>

        <div id="modificationInfo" class="mt-5">
          <form action="event_verif-modif.php?id=<?=$event["id"]?>" method="post"  enctype="multipart/form-data">
            <input type="text" class="form-control" name="title" value="<?=$event["title"]?>">

            <div class="mb-3">
              <label class="form-label">Images <i style="color:grey">(facultatif)</i></label>
              <div class="input-group">
                <input type="file" class="form-control" name="image0" id="image">
                <input type="file" class="form-control" name="image1" id="image">
                <input type="file" class="form-control" name="image2" id="image">
                <input type="file" class="form-control" name="image3" id="image">
                <input type="file" class="form-control" name="image4" id="image">
              </div>
            </div>


            <div class="d-flex mb-3 mt-3 justify-content-evenly">
              <select class="form-select" name="type">
                <option selected><?=$event["type"]?></option>
                <option value="Rencontre">Rencontre</option>
                <option value="Montagne">Montagne</option>
                <option value="Plat">Plat</option>
                <option value="Foret">Fôret</option>
                <option value="Circuit">Circuit</option>
                <option value="Course">Course</option>
              </select>
              <input type="date" class="form-control" name="date_event" value="<?=date_format($date,"Y-m-d")?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea class="form-control" name="description" rows="5"><?=$event["description"]?></textarea>
            </div>

            <input type="submit" class="btn btn-primary form-control mb-3" value="Modifier">
          </form>
          <?php
            if($_SESSION['id'] == $event['id_creater']){
              echo '<a class="text-center mt-4" href="event_delete.php?id='.$event["id"].'"><button class="btn btn-danger">Supprimer l\'event</button></a>';
            }
          ?>
        </div>
      </div>

    </main>
  </body>
</html>
