<?
session_start();

include('includes/verif_user.php');

if(!isset($_SESSION["email"])){
  // si n'est pas connecter, redirige vers la page event
  header('location: event_list.php?message=Vous devez être connecter pour accéder à ce contenue.');
  exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Créer un évènement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="scripts/form.js" charset="utf-8"></script>
    <style>
      #image{
        margin: 3px;
      }
    </style>
  </head>
  <main>
    <br>
    <div class="container">
      <h1>Créer un évènement</h1>
      <form action="verif-add_event.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Titre de l'évènement</label>
          <input type="text" class="form-control" name="title" placeholder="ex: Balade dans les Alpes">
        </div>
        <div class="mb-3">
          <label class="form-label">Type d'évènement</label>
          <select class="form-select" name="type">
            <option selected>...</option>
            <option value="Rencontre">Rencontre</option>
            <option value="Montagne">Montagne</option>
            <option value="Plat">Plat</option>
            <option value="Foret">Fôret</option>
            <option value="Circuit">Circuit</option>
            <option value="Course">Course</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Date de l'évènement</label>
          <input class="form-control" type="date" name="date_event">
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea class="form-control" name="description" rows="5"></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Images <i style="color:grey">(minimum 1)</i></label>
          <div class="input-group">
            <input type="file" class="form-control" name="image0" id="image">
            <input type="file" class="form-control" name="image1" id="image">
            <input type="file" class="form-control" name="image2" id="image">
            <input type="file" class="form-control" name="image3" id="image">
            <input type="file" class="form-control" name="image4" id="image">
          </div>
        </div>
        <div class="mb-3">
          <button type="submit" class="btn btn-primary">Créer</button>
        </div>
      </form>
    </div>
  </main>
</html>
