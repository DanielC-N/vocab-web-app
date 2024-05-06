<?php
function getBaseDD(){
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');

    $resultats = $bdd->query('SELECT * FROM vocabulaire ORDER BY created DESC; ');

    return $resultats;
//delete
//get 
//add
}

?>