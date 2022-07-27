<!DOCTYPE html>
<html>
  <head>
    <title>Ajouter une location (test)</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php include('../includes/backoffice-header.php'); ?>
    <main>
      <div class="container">
        <form action="verif-add_location.php" method="post">
          <div class="form-floating mb-3">
            <input class="form-control" type="number" name="id_reserv" placeholder=".">
            <label>Id reservation</label>
          </div>
          <div class="d-flex justify-content-between mb-3">
            <div class="form-floating col-5">
              <input class="form-control" type="text" name="latitude" placeholder=".">
              <label>Latitude</label>
            </div>
            <div class="form-floating col-5">
              <input class="form-control" type="text" name="longitude" placeholder=".">
              <label>Longitude</label>
            </div>
          </div>
          <input class="form-control btn btn-primary" type="submit">
        </form>
      </div>
    </main>
  </body>
</html>
