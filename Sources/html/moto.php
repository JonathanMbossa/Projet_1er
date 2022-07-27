<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>HJQ-Motors</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
		<script src="scripts/moto-sort.js" charset="utf-8"></script>
    <script src="scripts/catalog.js" charset="utf-8"></script>
	</head>
	<body id="culot">
		<header>
			<img class="img-fluid" src="img\photo7.jpg">
		</header>
		<div class="container-fluid">
	   <div class="container">
			 <div class="row">
         <div class="col-xs-12">
           <nav>
             <div class="nav nav-tabs nav-fill" id="nav-tab">
               <a class="nav-item nav-link" id="sortPriceBar" onclick="deployBar('child_sortPriceBar',0)">Filtrer par prix</a>
               <!-- <a class="nav-item nav-link" id="sortTypeBar" onclick="deployBar('child_sortTypeBar',1)">Filtrer par type</a> -->
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
             <!-- <div id="child_sortTypeBar" style="display:none">
               <div class="nav nav-tabs nav-fill">
                 <a class="nav-item nav-link" onclick="sortType('casque')">Casques</a>
                 <a class="nav-item nav-link" onclick="sortType('veste')">Vestes</a>
                 <a class="nav-item nav-link" onclick="sortType('gants')">Gants</a>
                 <a class="nav-item nav-link" onclick="sortType('pantalon')">Pantalons</a>
                 <a class="nav-item nav-link" onclick="sortType('bottes')">Bottes</a>
               </div>
             </div>-->
             <div id="child_sortMarkBar" style="display:none">
               <div class="nav nav-tabs nav-fill">
                 <a class="nav-item nav-link" onclick="sortMark('BMW')">BMW</a>
                 <a class="nav-item nav-link" onclick="sortMark('KTM')">KTM</a>
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
			 <br>
	    <div class="row">
				<?php
					session_start();
          include("includes/db_connexion.php");
					$sort = 'moto';
					include("includes/sort.php");



					if(isset($_SESSION["id"])){
						$req_verif = $db->prepare('SELECT birth_date,admin FROM users WHERE id = ?');
						$req_verif->execute([$_SESSION["id"]]);
						$verif = $req_verif->fetch();

						if($verif['birth_date']){
							$birth = date_create($verif["birth_date"]);
							$birthFormat = date_format($birth, "Y-m-d");
		         	$age = date('Y') - date_format($birth, "Y");;
			        if (date('md') < date('md', strtotime($birthFormat))) {
			            $age -= 1;
			        }
						} else {
							$age = 99;
						}

						$age = $verif["admin"] ? 99 : $age;

	          if(isset($req_min['_min']) && isset($req_max['_max'])){
		          for ($i = $req_min['_min']; $i <= $req_max['_max']; $i++) {
								$r = 'SELECT * FROM moto WHERE id = (?) AND age_min <= ?';
		            $requete= $db->prepare($r); //requête test
								$requete->execute([$i, $age]);
		            $req = $requete->fetch(); //prend la prmière ligne de la requête
		            if($req){ //vérifie que la ligne existe bien dans la table
		              // Duplique x* fois la template pour de produit avec les infos de la bdd (* x étant le nombre d'éléments dans la base de données)
		              echo '<div class="col-md-4 col-sm-6 col-sx-12" id="'.$req["puissance"].'-'.$req["marque"].'-'.$req["model"].'-'.$req["prix"].'-'.$req["prix"].'">
									      	<div class="product-grid" id="moto">
									        	<div class="product-image">
									          	<a href="moto_page.php?id='.$req["id"].'">
									            	<img class="pic-1" src="uploads/motos/'.$req["image1"].'">
									            	<img class="pic-2" src="uploads/motos/'.$req["marque"].'-logo.png">
															</a>
														</div>
														<div class="product-content">
										        	<h3 class="title"><a href="moto_page.php?id='.$req["id"].'">'.$req["marque"].'  '.$req["model"].'</a></h3>
										        	<div>
																<span>Disponible</span>
											        	<!--<span>Résérver</span>-->
										          </div>
										          <!-- <span>999 CV</span> -->
															<a class="add-to-cart">'.$req["prix"].'€/jour</a>
										        </div>
										    	</div>
										    </div>';
		            }
		          }
		        }
					} else {
						if(isset($req_min['_min']) && isset($req_max['_max'])){
		          for ($i = $req_min['_min']; $i <= $req_max['_max']; $i++) {
								$r = 'SELECT * FROM moto WHERE id = (?)';
		            $requete= $db->prepare($r); //requête test
								$requete->execute([$i]);
		            $req = $requete->fetch(); //prend la prmière ligne de la requête
		            if($req){ //vérifie que la ligne existe bien dans la table
		              // Duplique x* fois la template pour de produit avec les infos de la bdd (* x étant le nombre d'éléments dans la base de données)
		              echo '<div class="col-md-4 col-sm-6 col-sx-12" id="'.$req["puissance"].'-'.$req["marque"].'-'.$req["model"].'-'.$req["prix"].'-'.$req["prix"].'">
									      	<div class="product-grid" id="moto">
									        	<div class="product-image">
									          	<a href="moto_page.php?id='.$req["id"].'">
									            	<img class="pic-1" src="uploads/motos/'.$req["image1"].'">
									            	<img class="pic-2" src="uploads/motos/'.$req["marque"].'-logo.png">
															</a>
														</div>
														<div class="product-content">
										        	<h3 class="title"><a href="moto_page.php?id='.$req["id"].'">'.$req["marque"].'  '.$req["model"].'</a></h3>
										        	<div>
																<span>Disponible</span>
											        	<!--<span>Résérver</span>-->
										          </div>
										          <!-- <span>999 CV</span> -->
															<a class="add-to-cart">'.$req["prix"].'€/jour</a>
										        </div>
										    	</div>
										    </div>';
		            }
		          }
		        }
					}
      ?>


	    	<!-- <div class="col-md-4 col-sm-6 col-sx-12">
	      	<div  class="product-grid" id="moto">
	        	<div   class="product-image">
	          	<a href="#">
	            	<img class="pic-1" src="img\bmw-s-1000-rr_2.jpg">
	            	<img class="pic-2" src="img\logo-bmw-1-normal-636.png">
							</a>
						</div>
						<div class="product-content">
		        	<h3 class="title"><a href="#">Women's Blouse</a></h3>
		        	<div>
			        	<span>Résérver</span>
		          </div>
		          <!-- <span>999 CV</span>
							<a class="add-to-cart" href="">Ajoutez au panier</a>
		        </div>
		    	</div>
		    </div> -->


			</div>
	  </div>
	</body>
</html>
