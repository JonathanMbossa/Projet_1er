<!DOCTYPE html>
<html>
  <head>
    <title>Page d'équipement</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <style>
      hr{
        margin: auto;
        margin-bottom: 15px;
        width: 75%;
      }

      body{
        background-color: #ededed;
      }
      div.container{
        background-color: white;
        max-width: 1170px;
      }

      div#list-same{
        margin-top: 10em;
      }

      p.lead {
        font-size: 1.5em !important;
      }

      div.container > h1 {
        font-weight: bold;
        margin-bottom: 20px;
      }

      div#list-same-product{
        display:flex;
        overflow: scroll;
        overflow-y: hidden;
        overflow-x: scroll;
      }

      div#buy{
        margin-top:5em;
      }

      div.col-md-2.col-sm-4.col-sx-6 {
        margin-right: 30px;
      }

      h3.h3{ /* TITRE  */
          text-align:center;
          margin:1em;
          font-weight:bold;
          }


      .product-grid{
          text-align:center;
          padding:0 0 72px;
          border:1px solid rgba(0,0,0,.1);
          overflow:hidden;
          position:relative;
          z-index:1;
      }


      .product-grid .product-image img{
          width:100%;
          height:auto;
      }



      .product-grid .pic-2{/* permet a la deuxieme image de se mettre sur la premiere avec un effet de transition*/
          opacity:0;
          position:absolute;
          top:0;
          left:0;
          transition:all .3s ease-out 0s;
      }

      .product-grid:hover .pic-2{/* fais la transition d'image*/
          transition: .3;
          opacity:1;
      }



      .product-grid .product-discount-label,
      .product-grid .product-new-label{/*taille des soldes, et couleur */
          color:#fff;
          background-color:#ef5777;
          font-size:12px;
          padding:2px 7px;
          display:block;
          position:absolute;
          top:10px;
          left:0
      }

      .product-grid .product-discount-label{ /* pour les soldes et réduction */
          background-color:#333;
          left:auto;
          right:0
      }


      .product-grid .product-content{/* partie base du block*/
          background-color:#fff;
          padding:12px 0;
          position:absolute;
          left:0;
          right:0;
          bottom:-27px;
          transition:all .3s
      }

      .product-grid:hover .product-content{/* ce qui donne l'effet de monter de liens et du prix */
          bottom:0
          }

      .product-grid .title{/*taille du h3 */
          font-size:13px;
      }
      .product-grid .title a{ /*couleur de base  du h3 */
          color:black;
      }


      .product-grid .price{/* ligne pour le prix*/
          margin-bottom:8px;
          text-align:center;
          transition:all .3s;
          }
      .product-grid .price span{/* ligne pour le prix*/
          text-decoration:line-through;
          margin-left:3px;
          display:inline-block
          }

      .product-grid .add-to-cart{/* lien permettant d'ajouter au panier*/
          color:#000;
          font-size:13px;
          font-weight:600
      }

      .product-grid{margin-bottom:30px} /* espace entre les block*/

    </style>
  </head>
  <body>
    <main>

      <?php
        if(!isset($_GET['id']) || empty($_GET['id'])){
          header('location: equip.php');
          exit;
        }

        include("includes/db_connexion.php");
        $q = 'SELECT * FROM equipement WHERE id = ?';
        $req = $db->prepare($q);
        $req->execute([$_GET["id"]]);
        $equip = $req->fetch();
      ?>

      <div class="container">
        <h1 class="text-center text-uppercase"><?=$equip["marque"].' '.$equip["model"]?></h1>

        <div class="row">
          <div>
            <img style="float:left;width:35%;" src="uploads/equipements/<?=$equip['image1']?>">
            <p class="text-center lead"><?=$equip['description']?></p>
          </div>
        </div>

        <div id="buy" class="text-center">
          <h4><?=$equip['prix']?>€</h4>
          <button class="btn btn-primary">Ajouter au panier <i class="bi bi-cart2"></i></button>
        </div>

        <div id="list-same">
          <hr>
          <h3 class="text-center">De la même marque</h3>
          <br>
          <div id="list-same-product" class="container horizontal-scrollable">
            <?php

              $sort = 'equipement';
              include("includes/sort.php");

              $v = 'SELECT COUNT(*) FROM equipement WHERE marque = (:marque) AND model != (:model) ';
              $req_verif = $db->prepare($v);
              $req_verif->execute([
                'marque' => $equip["marque"],
                'model' => $equip["model"]
              ]);
              $verif = $req_verif->fetch();

              $x = $verif[0] < 10 ? $verif[0] : 10;


              if(isset($req_min['_min'])){
                $i = $req_min['_min'];
                for ($y = 0; $y < $x; $i++) {
                  $r = 'SELECT * FROM equipement WHERE id = (:id) AND marque = (:marque) AND model != (:model)';
                  $requete= $db->prepare($r); //requête test
                  $requete->execute([
                    "id" => $i,
                    "marque" => $equip["marque"],
                    'model' => $equip["model"]
                  ]);
                  $req = $requete->fetch(); //prend la prmière ligne de la requête
                  if($req){ //vérifie que la ligne existe bien dans la table
                    $y++;
                    // Duplique x* fois la template pour de produit avec les infos de la bdd (* x étant le nombre d'éléments dans la base de données)
                    echo '<div class="col-md-2 col-sm-4 col-sx-6">
                            <div class="product-grid" id="equipement">
                              <div class="product-image">
                                <a href="equipement_page.php?id='.$req["id"].'">
                                  <img class="pic-1" src="uploads/equipements/'.$req["image1"].'">
                                  <img class="pic-2" src="uploads/equipements/'.$req["image2"].'">
                                </a>
                              </div>
                              <div class="product-content">
                                <h3 class="title"><a href="equipment_page.php?id='.$req["id"].'">'.$req["marque"].'  '.$req["model"].'</a></h3>
                                <div class="price">
                                    '.$req["prix"].'€
                                </div>
                                <a class="add-to-cart">Ajoutez au panier</a>
                              </div>
                            </div>
                          </div>';
                  }
                }
              }
            ?>
          </div>
        </div>
      </div>




    </main>
  </body>
</html>
