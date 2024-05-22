<?php
function getBaseDD(){
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');

    $resultats = $bdd->query('SELECT * FROM vocabulaire ORDER BY created DESC; ');

    return $resultats;
}

function filterWord($text){

    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');

    $resultats = $bdd->query('SELECT * FROM vocabulaire WHERE mot_fr LIKE \'%' . $text . '%\'  OR mot_en LIKE \'%' . $text . '%\'; ');

    return $resultats;
 }

function deleteWord($id){

    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');

    $resultats = $bdd->query('DELETE FROM vocabulaire WHERE id = ' . $id . ' ;');

    return $resultats;
}

function getWord($id){

    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');

    $resultats = $bdd->query('SELECT * FROM vocabulaire WHERE id = ' . $id . ' ;');

    return $resultats;
}


function insertWord($textfr, $texten, $note){

    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt= $bdd->prepare('INSERT INTO vocabulaire (mot_fr,mot_en,note) VALUES(:fr, :en, :note)');
    $stmt->execute(['fr'=> $textfr,'en'=>$texten,'note'=>$note]);
    
    // $resultats = $bdd->query('INSERT INTO vocabulaire (mot_fr, mot_en, note) VALUES (\'' . $textfr . '\', \'' . $texten .'\', \'' . $note . '\');');
    // return $resultats;

    // echo `INSERT INTO vocabulaire (mot_fr, mot_en, note) VALUES ('$textfr', '$texten', '$note';`;

} 
 function updateWord($id, $textfr, $note){

        $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
        $stmt= $bdd->prepare('UPDATE vocabulaire SET mot_fr=:fr, note=:note WHERE id=:id');
       
        $stmt->execute(['fr'=> $textfr,'note'=>$note, 'id'=>$id]); 
       
}

// ?>


<!-- $connexion = mysql_connect()
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

$insertBaseDD-> --> 
