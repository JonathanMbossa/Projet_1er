<?php
// Connexion à la base de données
include('includes/db_connexion.php');

// Vérifier si un chat existe déjà
$p = 'SELECT id FROM chat WHERE id_user1 = :id_user1';
$req_verif = $db->prepare($p);
$req_verif->execute([
	'id_user1' => $_POST['id_user1'];
]);
$verif = $req_verif ->fetch();

// format de date et heure
$dateTime = date('Y-m-d-h-i-s');

if($verif){
  // Insérer un nouveau message dans le chat
  $q = 'INSERT INTO message (content, send_time,id_sender,id_chat) VALUES (:content, :send_time,:id_sender,:id_chat)';
  $req = $db->prepare($q);
  $reponse = $req->execute([
  	'content' => $_POST['content'], // Contenue du message
    'send_time' => $dateTime, // Heure de l'envoie
    'id_sender' => $_POST['id_user1'], // id de l'envoyeur
    'id_chat' => $verif[0] // id du chat
  ]);
} else {
  $q = 'INSERT INTO chat (id_user1, id_user2) VALUES (:id_user1, :id_user2)';
  $req = $db->prepare($q);
  $reponse = $req->execute([
    'id_user1' => $_POST['id_user1'],
    'id_user2' => 7
  ]);

  // Insérer un nouveau message dans le chat
  $q = 'INSERT INTO message (content, send_time,id_sender,id_chat) VALUES (:content, :send_time,:id_sender,:id_chat)';
  $req = $db->prepare($q);
  $reponse = $req->execute([
    'content' => $_POST['content'], // Contenue du message
    'send_time' => $dateTime, // Heure de l'envoie
    'id_sender' => $_POST['id_user1'], // id de l'envoyeur
    'id_chat' => $verif[0] // id du chat
  ]);
}

?>
