<?php session_start()?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="img/icon.png" />
    <link rel="stylesheet" href="css/test.css">
    <title>Evenements</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  </head>
  <body id="event">
    <main>
      <div class="container">
        <?php
          include("includes/db_connexion.php");
          include('includes/event_table.php');


          if(isset($_SESSION['id'])){
            $requete = $db->query('SELECT * FROM gouts WHERE id_user = '.$_SESSION["id"]);
            $gout = $requete->fetch();
          }
          if(isset($_SESSION['id']) && (isset($gout["gout1"]) || isset($gout["gout2"]) || isset($gout["gout3"]))){
            if($gout["gout1"] || $gout["gout2"] || $gout["gout3"]){
              for($i = 1; $i <= 3; $i++){
                if($gout["gout".$i]){
                  foreach ($eventSort as $key => $value) {
                    if($eventSort[$key]['type'] == $gout["gout".$i]){
                      $t = 'SELECT * FROM event WHERE id = ?';
                      $requete = $db->prepare($t); //requête test
                      $requete->execute([$eventSort[$key]['id']]);
                      $req = $requete->fetch(); //prend la prmière ligne de la requête

                      $o = 'SELECT firstname,lastname FROM users WHERE id = ?';
                      $req_creater = $db->prepare($o); //requête test
                      $req_creater->execute([$req["id_creater"]]);
                      $creater = $req_creater->fetch(); //prend la prmière ligne de la requête

                      if($test){ //vérifie que la ligne existe bien dans la table
                        $date = date_create($req["date_event"]);
                        echo '<div class="list-group">
                                <a href="event_page.php?id='.$req["id"].'" class="list-group-item list-group-item-action">
                                  <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-2">'.$req["title"].'</h5>
                                    <small>le '.date_format($date,"d/m/Y").'</small>
                                  </div>
                                  <p class="mb-3 col-xs-12 col-lg-10" maxlength="10">
                                      '.$req["description"].'
                                  </p>
                                  <!-- <p style="text-align: right; margin-bottom: 0; width: 200px; right: 0;">Montagne</p> -->
                                  <div style="display:flex; justify-content: space-between; align-items: flex-end">
                                    <small><img src="uploads/photos_profils/default_user.png" style="width: 50px; border: 1.5px solid black;" class="rounded-circle"> '.$creater["firstname"].'  '.$creater["lastname"].'</small>
                                    <!-- <small >Montagne</small> -->
                                    <p style="margin-bottom: 0; ">'.$req["type"].'</p>
                                  </div>
                                </a>
                              </div>
                              <br>';
                      }
                    }
                  }
                }
              }

              foreach ($eventSort as $key => $value) {
                  if($eventSort[$key]['type'] != $gout["gout1"] && $eventSort[$key]['type'] != $gout["gout2"] && $eventSort[$key]['type'] != $gout["gout3"]){
                    $t = 'SELECT * FROM event WHERE id = ?';
                    $requete = $db->prepare($t); //requête test
                    $requete->execute([$eventSort[$key]['id']]);
                    $req = $requete->fetch(); //prend la prmière ligne de la requête

                    $o = 'SELECT firstname,lastname FROM users WHERE id = ?';
                    $req_creater = $db->prepare($o); //requête test
                    $req_creater->execute([$req["id_creater"]]);
                    $creater = $req_creater->fetch(); //prend la prmière ligne de la requête

                    if($test){ //vérifie que la ligne existe bien dans la table
                      $date = date_create($req["date_event"]);
                      echo '<div class="list-group">
                              <a href="event_page.php?id='.$req["id"].'" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                  <h5 class="mb-2">'.$req["title"].'</h5>
                                  <small>le '.date_format($date,"d/m/Y").'</small>
                                </div>
                                <p class="mb-3 col-xs-12 col-lg-10" maxlength="10">
                                    '.$req["description"].'
                                </p>
                                <!-- <p style="text-align: right; margin-bottom: 0; width: 200px; right: 0;">Montagne</p> -->
                                <div style="display:flex; justify-content: space-between; align-items: flex-end">
                                  <small><img src="uploads/photos_profils/default_user.png" style="width: 50px; border: 1.5px solid black;" class="rounded-circle"> '.$creater["firstname"].'  '.$creater["lastname"].'</small>
                                  <!-- <small >Montagne</small> -->
                                  <p style="margin-bottom: 0; ">'.$req["type"].'</p>
                                </div>
                              </a>
                            </div>
                            <br>';
                    }
                  }
                }
              }

          } else {
            $sort = 'event';
    				include('includes/sort.php');
    				if($req_min['_min'] != NULL && $req_max['_max'] != NULL){
    				for ($i = $req_min['_min']; $i <= $req_max['_max']; $i++) {
    					$req_test = $db->query('SELECT id FROM event WHERE id ='.$i); //requête test
    					$test = $req_test->fetch(PDO::FETCH_ASSOC); //prend la prmière ligne de la requête
    					if($test){ //vérifie que la ligne existe bien dans la table
    						$requete = $db->query('SELECT * FROM event WHERE id = '.$i); //Selection de toute la ligne avec l'id de valeur $i
    						$req = $requete->fetch();
    						// recup le nom et prénom du créateur
    						$q = 'SELECT firstname,lastname,pp FROM users WHERE id = :id_creater';
    						$req_user = $db->prepare($q);
    						$req_user->execute([
    							'id_creater' => $req['id_creater']
    						]);
    						$creater = $req_user ->fetch();
                $date = date_create($req["date_event"]);

                echo '<div class="list-group">
                        <a href="event_page.php?id='.$req["id"].'" class="list-group-item list-group-item-action">
                          <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-2">'.$req["title"].'</h5>
                            <small>le '.date_format($date,"d/m/Y").'</small>
                          </div>
                          <p class="mb-3 col-xs-12 col-lg-10" maxlength="10">
                              '.$req["description"].'
                          </p>
                          <!-- <p style="text-align: right; margin-bottom: 0; width: 200px; right: 0;">Montagne</p> -->
                          <div style="display:flex; justify-content: space-between; align-items: flex-end">
                            <small><img src="uploads/photos_profils/'.$creater['pp'].'" style="width: 50px; border: 1.5px solid black;" class="rounded-circle"> '.$creater["firstname"].'  '.$creater["lastname"].'</small>
                            <!-- <small >Montagne</small> -->
                            <p style="margin-bottom: 0; ">'.$req["type"].'</p>
                          </div>
                        </a>
                      </div>
                      <br>';
                }
    					}
    				}

          }



            //   for($i = 0; $i < count($eventSort); $i++){
            //     $t = 'SELECT * FROM event WHERE id = ?';
            //     $requete = $db->prepare($t); //requête test
            //     $requete->execute([$eventSort[$i]]);
            //     $req = $requete->fetch(); //prend la prmière ligne de la requête
            //     $o = 'SELECT firstname,lastname FROM users WHERE id = ?';
            //     $req_creater = $db->prepare($o); //requête test
            //     $req_creater->execute([$req["id_creater"]]);
            //     $creater = $req_creater->fetch(); //prend la prmière ligne de la requête
            //     if($test){ //vérifie que la ligne existe bien dans la table
            //       $date = date_create($req["date_event"]);
            //       echo '<div class="list-group">
            //               <a href="#" class="list-group-item list-group-item-action">
            //                 <div class="d-flex w-100 justify-content-between">
            //                   <h5 class="mb-2">'.$req["title"].'</h5>
            //                   <small>le '.date_format($date,"d/m/Y").'</small>
            //                 </div>
            //                 <p class="mb-3 col-xs-12 col-lg-10" maxlength="10">
            //                     '.$req["description"].'
            //                 </p>
            //                 <!-- <p style="text-align: right; margin-bottom: 0; width: 200px; right: 0;">Montagne</p> -->
            //                 <div style="display:flex; justify-content: space-between; align-items: flex-end">
            //                   <small><img src="uploads/photos_profils/default_user.png" style="width: 50px; border: 1.5px solid black;" class="rounded-circle"> '.$creater["firstname"].'  '.$creater["lastname"].'</small>
            //                   <!-- <small >Montagne</small> -->
            //                   <p style="margin-bottom: 0; ">'.$req["type"].'</p>
            //                 </div>
            //               </a>
            //             </div>
            //             <br>';
            //     }
            //   }
            // }

            // $sort = 'event';
    				// include('includes/sort.php');
            //
    				// if($req_min['_min'] != NULL && $req_max['_max'] != NULL){
    				// for ($i = $req_min['_min']; $i <= $req_max['_max']; $i++) {
    				// 	$req_test = $db->query('SELECT id FROM event WHERE id ='.$i); //requête test
    				// 	$test = $req_test->fetch(PDO::FETCH_ASSOC); //prend la prmière ligne de la requête
    				// 	if($test){ //vérifie que la ligne existe bien dans la table
    				// 		$requete = $db->query('SELECT * FROM event WHERE id = '.$i); //Selection de toute la ligne avec l'id de valeur $i
    				// 		$req = $requete->fetch();
    				// 		// recup le nom et prénom du créateur
    				// 		$q = 'SELECT firstname,lastname FROM users WHERE id = :id_creater';
    				// 		$req_user = $db->prepare($q);
    				// 		$req_user->execute([
    				// 			'id_creater' => $req['id_creater']
    				// 		]);
    				// 		$creater = $req_user ->fetch();
            //     $date = date_create($req["date_event"]);
            //
            //     echo '<div class="list-group">
            //             <a href="#" class="list-group-item list-group-item-action">
            //               <div class="d-flex w-100 justify-content-between">
            //                 <h5 class="mb-2">'.$req["title"].'</h5>
            //                 <small>le '.date_format($date,"d/m/Y").'</small>
            //               </div>
            //               <p class="mb-3 col-xs-12 col-lg-10" maxlength="10">
            //                   '.$req["description"].'
            //               </p>
            //               <!-- <p style="text-align: right; margin-bottom: 0; width: 200px; right: 0;">Montagne</p> -->
            //               <div style="display:flex; justify-content: space-between; align-items: flex-end">
            //                 <small><img src="uploads/photos_profils/default_user.png" style="width: 50px; border: 1.5px solid black;" class="rounded-circle"> '.$creater["firstname"].'  '.$creater["lastname"].'</small>
            //                 <!-- <small >Montagne</small> -->
            //                 <p style="margin-bottom: 0; ">'.$req["type"].'</p>
            //               </div>
            //             </a>
            //           </div>
            //           <br>';
            //     }
    				// 	}
    				// }


        ?>

<!--
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-2">Promenade dans les petites routes des Alpes</h5>
              <small>le 20/03/2021</small>
            </div>
            <p class="mb-3 col-xs-12 col-lg-10">
              Oportunum est, ut arbitror, explanare nunc causam, quae ad exitium praecipitem Aginatium
              inpulit iam inde a priscis maioribus nobilem, ut locuta est pertinacior
              fama. nec enim super hoc ulla documentorum rata est fides.
            </p>
             <p style="text-align: right; margin-bottom: 0; width: 200px; right: 0;">Montagne</p>
            <div style="display:flex; justify-content: space-between; align-items: flex-end">
              <small><img src="uploads/photos_profils/default_user.png" style="width: 50px; border: 2px solid black;" class="rounded-circle"> Quentin Hélion</small>
              <small >Montagne</small>
              <p style="margin-bottom: 0; ">Montagne</p>
            </div>
          </a>
        </div> -->

      </div>
    </main>
  </body>
</html>
