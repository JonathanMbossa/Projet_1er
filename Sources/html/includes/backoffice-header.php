<header>
  <link rel="stylesheet" href="../css/backoffice-style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <div class="row">
      <div class="col-xs-12">
        <nav>
          <div class="nav nav-tabs nav-fill" id="nav-tab">
            <a class="nav-item nav-link" id="nav-home-tab" href="../backoffice/backoffice-index.php">Tableau de bord</a>
            <a class="nav-item nav-link" id="nav-home-tab" href="../backoffice/track_stats.php">Stats du tracking</a>
            <a class="nav-item nav-link" id="nav-home-tab" href="../backoffice/carte.php">Carte</a>
            <a class="nav-item nav-link" id="nav-home-tab" href="../backoffice/db_users.php">Database users</a>
            <a class="nav-item nav-link" id="nav-profile-tab" href="../backoffice/db_event.php">Database event</a>
            <a class="nav-item nav-link" id="nav-contact-tab" href="../backoffice/db_moto.php">Database motos</a>
            <a class="nav-item nav-link" id="nav-about-tab" href="../backoffice/db_equipement.php">Database équipements</a>
            <a class="nav-item nav-link" id="nav-about-tab" href="../index.php">Retour au site</a>
          </div>
        </nav>
      </div>
    </div>
    <?php include('backoffice-verif_acces.php'); ?>
    <?php
      $path = "../uploads/";
      include("motoMessage.php");
    ?>
</header>
