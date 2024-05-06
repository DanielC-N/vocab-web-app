<?php
function getBaseDD(){
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');

    $resultats = $bdd->query('SELECT * FROM vocabulaire ORDER BY created DESC; ');

    return $resultats;
}
?>
<!--delete
DELETE FROM vocabulaire WHERE id= nombre;

$connexion = mysql_connect()
*/
//get 
UPDATE vocabulaire SET mot_fr =:mot_fr, mot_en=:mot_en, note=:note, vocabulaire=:vocabulaire WHERE vocabualaire_id=:id 


/* add 
try {
    $resultats =getBaseDD();
}
catch (Exception $e) {
    die ('erreur : ' . $e->getMessage());
}
$sqlQuery = 'INSERT INTO recipes(mot_fr,mot_en,note) VALUES (:mot_fr,:mot_en,:note)';

$insertBaseDD = $resultats-> prepare($sqlQuery);

$insertBaseDD->
-->