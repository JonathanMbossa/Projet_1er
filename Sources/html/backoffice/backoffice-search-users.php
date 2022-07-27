<!DOCTYPE html>
   <html>
     <head>
       <title>Tableau de bord</title>
   		<meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
       <link rel="stylesheet" href="../css/backoffice-style.css">
     </head>
     <body>
       <?php include('../includes/db_connexion.php'); ?> <!-- Connexion à la base de données -->
       <?php include('../includes/backoffice-header.php'); ?>
       <main>
         <div class="container">
           <div class="row">
             <div class="col-md-3 col-sm-6" id="lastAddEquip">
               <h1> Rechercher un utilisateurs </h1><br>

  <form action="" method="get">
       <div class="input-group mb-3">
         <input type="search" class="form-control" placeholder="Rechercher un utilisateurs" aria-label="Recipient's username" aria-describedby="basic-addon2" name="search">

            <input  type="submit" name="Rechercher">
        </div>

  </form>

  <?php
  include('includes/db_connexion.php');
  $allUsers = $db->query('SELECT * FROM users ORDER BY id DESC');
  if (isset($_GET['search']) AND !empty($_GET['search'])) {
  $recherche = htmlspecialchars(($_GET['search']));

  $allUsers = $db->query('SELECT email FROM users WHERE email LIKE "%'. $recherche. '%" ORDER BY id DESC LIMIT 0, 5');
}
  ?>
               <section>

               <?php
                      if ($allUsers->rowCount() > 0) { // permet de compter le nb users
                      while ($users = $allUsers->fetch()) {
                      ?>
                      <p><?=$users['email'] ?> et possede l'id n° <?=$users['id'] ?></p>

                      <?php
                      }
                      } else {
                      ?>
                      <p>aucun users trouvé</p>
                            <?php
                      }
                      ?>
                </section>


            </div>
           </div>
         </div>
       </main>
     </body>
   </html>
