<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Catalogue moto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
    crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="scripts/equipment-sort.js" charset="utf-8"></script>
    <script src="scripts/catalog.js" charset="utf-8"></script>
  </head>
  <body id="culot">
    <header class="container">
    </header>
    <body>
    <!-- barre de menu -->
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <nav>
            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true" onclick="resetFilter()">Equipements</a>
              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Outils</a>
              <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Connectez-vous</a>
              <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">Panier</a>
            </div>
          </nav>
        </div>
      </div>
    </div>
    <!-- Barre de filtre -->
    <!-- <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <nav>
            <div class="nav nav-tabs nav-fill" id="nav-tab">
              <a class="nav-item nav-link" id="sortPriceBar" onclick="deployBar('child_sortPriceBar',0)">Filtrer par prix</a>
              <a class="nav-item nav-link" id="sortTypeBar" onclick="deployBar('child_sortTypeBar',1)">Filtrer par type</a>
              <a class="nav-item nav-link" id="sortMarkBar" onclick="deployBar('child_sortMarkBar',2)">Filtrer par marque</a>
              <a class="nav-item nav-link" id="sortAlphabeticBar" onclick="deployBar('child_sortAlphabeticBar',3)">Filtrer par ordre alphabétique</a>
              <input class="nav-item nav-link" type="text" id="sortSearch" placeholder="Rechercher">
              <a class="nav-item nav-link" onclick="sortSearchBar()"> Rechercher </a>
            </div>
            <div id="child_sortPriceBar" style="display:none">
              <div class="nav nav-tabs nav-fill">
                <a class="nav-item nav-link" onclick="sortPriceAscend()">Prix croissant</a>
                <a class="nav-item nav-link" onclick="sortPriceDescend()">Prix décroissant</a>
              </div>
              <div class="nav nav-tabs nav-fill">
                  <input class="nav-item nav-link" type="number" id="sortMin" placeholder="Prix minimum">
                  <input class="nav-item nav-link" type="number" id="sortMax" placeholder="Prix maximum">
                  <a class="nav-item nav-link" onclick="sortPriceBetween()"> Valider </a>
              </div>
            </div>
            <div id="child_sortTypeBar" style="display:none">
              <div class="nav nav-tabs nav-fill">
                <a class="nav-item nav-link" onclick="sortType('casque')">Casques</a>
                <a class="nav-item nav-link" onclick="sortType('veste')">Vestes</a>
                <a class="nav-item nav-link" onclick="sortType('gants')">Gants</a>
                <a class="nav-item nav-link" onclick="sortType('pantalon')">Pantalons</a>
                <a class="nav-item nav-link" onclick="sortType('bottes')">Bottes</a>
              </div>
            </div>
            <div id="child_sortMarkBar" style="display:none">
              <div class="nav nav-tabs nav-fill">
                <a class="nav-item nav-link" onclick="sortMark('Alpinestars')">Alpinestars</a>
                <a class="nav-item nav-link" onclick="sortMark('test')">test</a>
              </div>
            </div>
            <div id="child_sortAlphabeticBar" style="display:none">
              <div class="nav nav-tabs nav-fill">
                <a class="nav-item nav-link" onclick="sortAlphabetic()">A-Z</a>
                <a class="nav-item nav-link" onclick="sortUnalphabetic()">Z-A</a>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </div> -->

    <br>
    <div class="container">
      <div class="row">
      <?php
      include("includes/db_connexion.php");
      $max = $db->query('SELECT max(id) AS _max FROM moto'); //requête SQL pour connaitre la taille du tableau
      $req_max = $max->fetch(PDO::FETCH_ASSOC); //prend la première ligne renvoyer
      $min = $db->query('SELECT min(id) AS _min FROM moto'); //requête SQL pour connaitre le debut du tableau
      $req_min = $min->fetch(PDO::FETCH_ASSOC); //prend la première ligne renvoyer

      //echo '<p>'.$max["id"].'-----'.$req_max['_max'].'</p>';
      if($req_min['_min'] != NULL && $req_max['_max'] != NULL){
      for ($i = $req_min['_min']; $i <= $req_max['_max']; $i++) {
        $req_test = $db->query('SELECT id FROM moto WHERE id ='.$i); //requête test
        $test = $req_test->fetch(PDO::FETCH_ASSOC); //prend la prmière ligne de la requête
        if($test){ //vérifie que la ligne existe bien dans la table
          $requete = $db->query('SELECT * FROM moto WHERE id = '.$i); //Selection de toute la ligne avec l'id de valeur $i
          $req = $requete->fetch();
          echo '<div class="col-md-3 col-sm-6" id="'.$req["puissance"].'-'.$req["marque"].'-'.$req["model"].'-'.$req["permis_req"].'">
                  <div class="product-grid">
                    <div class="product-image">
                      <a href="#">
                        <img class="pic-1" src="uploads/motos/'.$req["image1"].'" >
                        <img class="pic-2" src="uploads/motos/'.$req["image2"].'" >
                      </a>
                      <!-- span class="product-new-label">Solde</span> -->
                      <!-- <span class="product-discount-label">80%</span> -->
                    </div>
                    <div class="product-content">
                      <h3 class="title"><a href="#">'.$req["marque"].'   '.$req["model"].' </a></h3>
                      <div class="price">'.$req["permis_req"].'
                        <!-- <span>1300€</span> -->
                      </div>
                      <a class="add-to-cart" href="">Ajoutez au panier</a>
                    </div>
                  </div>
                  <br>
                </div><br>';
      }
    }
  }



    ?>
  </div>
</div>

    <!-- <div class="container">
      <h3 class="h3">Scorpion Exo</h3>
        <div class="row">
          <div class="col-md-3 col-sm-6">
            <div class="product-grid">
              <div class="product-image">
                <a href="#">
                  <img class="pic-1" src="Equipement\CASQUES\casqueScorpion/exo100.jpg" >
                  <img class="pic-2" src="Equipement\CASQUES\casqueScorpion/exo200.jpg">
                </a>
                <span class="product-new-label">Solde</span>
                <span class="product-discount-label">80%</span>
              </div>
              <div class="product-content">
                <h3 class="title"><a href="#">Casque pista </a></h3>
                <div class="price">400€
                  <span>1300€</span>
                </div>
                <a class="add-to-cart" href="">Ajoutez au panier</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><br> -->
  <?php include("includes/footer_catalogue.php"); ?>
  </body>
</html>
