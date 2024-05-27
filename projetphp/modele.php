<?php
function getBaseDD(){
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt =$bdd->prepare('SELECT * FROM vocabulaire ORDER BY mot_fr ');
    $stmt->execute(); 
    return $stmt->fetchAll();
    // $resultats = $bdd->query('SELECT * FROM vocabulaire ORDER BY created DESC; ');
    // return $resultats;
}

function getWordsByOffset($offset){
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt =$bdd->prepare('SELECT * FROM vocabulaire ORDER BY mot_fr LIMIT 10 OFFSET 10');
    $stmt->execute(); 
    return $stmt->fetchAll();
   
}

function filterWord($text){
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt =$bdd ->prepare("SELECT * FROM vocabulaire WHERE mot_en LIKE :en OR mot_fr LIKE :fr ");
    $stmt->execute(['en'=>'%'.$text.'%', 'fr'=>'%'.$text.'%']);
    return $stmt->fetchAll();

    // $resultats = $bdd->query('SELECT * FROM vocabulaire WHERE mot_fr LIKE \'%' . $text . '%\'  OR mot_en LIKE \'%' . $text . '%\'; ');
    // return $resultats;
 }

function deleteWord($id){
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt =$bdd ->prepare('DELETE FROM vocabulaire WHERE id =:id');
    $stmt->execute(['id'=>$id]);
    // $resultats = $bdd->query('DELETE FROM vocabulaire WHERE id = ' . $id . ' ;');
    // return $resultats; 

}
 
function getWord($id){
    $bdd=new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt=$bdd ->prepare('SELECT * FROM vocabulaire WHERE id =:id');
    $stmt->execute(['id'=>$id]);
    //$resultats = $bdd->query('SELECT * FROM vocabulaire WHERE id = ' . $id . ' ;');
    // return $resultats;
}

function insertWord($textfr, $texten, $note){
    echo('insert');
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt= $bdd->prepare('SELECT id FROM vocabulaire WHERE mot_en =:en');
    $stmt->execute(['en'=>$texten]);
    $r= $stmt->fetchAll();
    if(count($r)==0){
        $stmt= $bdd->prepare('INSERT INTO vocabulaire (mot_fr,mot_en,note) VALUES(:fr, :en, :note)');
        $stmt->execute(['fr'=> $textfr,'en'=>$texten,'note'=>$note]);
    } else {
        $id=$r[0]['id'];
        $stmt=$bdd->prepare('UPDATE vocabulaire SET mot_fr=:fr, note=:note WHERE id=:id');
        $stmt->execute(['fr'=> $textfr,'note'=>$note, 'id'=>$id]); 
    }

   
    
} 
 function updateWord($id, $textfr, $note){

    $bdd=new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt= $bdd->prepare('UPDATE vocabulaire SET mot_fr=:fr, note=:note WHERE id=:id');
    $stmt->execute(['fr'=> $textfr,'note'=>$note, 'id'=>$id]);
    return getBaseDD();
       
}
 
?>


