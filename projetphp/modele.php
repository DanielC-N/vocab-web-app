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

    echo `INSERT INTO vocabulaire (mot_fr, mot_en, note) VALUES ('$textfr', '$texten', '$note';`;
    $resultats = $bdd->query('INSERT INTO vocabulaire (mot_fr, mot_en, note) VALUES (\'' . $textfr . '\', \'' . $texten .'\', \'' . $note . '\');');
    return $resultats;
}

 function updateWord($id, $textfr, $texten, $note){

        $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
        
        $resultats = $bdd->query( 'UPDATE vocabulaire SET  ' . $textfr . '=mot_fr , mot_en = ' . $texten . ', note = ' . $note . ' WHERE id = ' . $id . ';');

        // $resultats ->query(['mot_fr'=>$mot_fr, 'mot_en'=>$mot_en, 'note'=>$note, 'id'=>$id ]); 
       
        return $resultats;
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
