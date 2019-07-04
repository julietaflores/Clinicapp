<?php

session_start();
// List of events
 $json = array();

 $clinica = $_SESSION['csmart']['clinica'];

 // Query that retrieves events
 $requete = "SELECT c.id, c.title,c.fecha,c.start,c.end,c.comentario,c.idtipocita,c.idpaciente
 			 FROM cita c join paciente p on c.idpaciente = p.idpaciente where p.idclinica=$clinica; ";

 // connection to the database
 try {
 $bdd = new PDO('mysql:host=localhost;dbname=clinica', 'root', 'root');
 } catch(Exception $e) {
  exit('Unable to connect to database.');
 }
 // Execute the query
 $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));

 // sending the encoded result to success page
 echo json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));

?>
