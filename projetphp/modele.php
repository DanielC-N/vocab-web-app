<?php
function getBaseDD(){
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt =$bdd->prepare('SELECT * FROM vocabulaire ORDER BY mot_fr ');
    $stmt->execute(); 
    return $stmt->fetchAll();
}

function getWordsByOffset(){
    var_dump('dedans');
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    //$stmt =$bdd->prepare('SELECT * FROM vocabulaire ORDER BY mot_fr LIMIT 10 OFFSET:offset');
    $stmt =$bdd->prepare('SELECT * FROM vocabulaire ORDER BY mot_fr LIMIT 0,30');
    $stmt->execute(); 
    //$stmt->execute(['offset'=> $offset,'mot_fr'=> $offset]); 
    return $stmt->fetchAll();
   
}

function filterWord($text){
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt =$bdd ->prepare("SELECT * FROM vocabulaire WHERE mot_en LIKE :en OR mot_fr LIKE :fr ");
    $stmt->execute(['en'=>'%'.$text.'%', 'fr'=>'%'.$text.'%']);
    return $stmt->fetchAll();
 }

function deleteWord($id){
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt =$bdd ->prepare('DELETE FROM vocabulaire WHERE id =:id');
    $stmt->execute(['id'=>$id]);
   

}
 
function getWord($id){
    $bdd=new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt=$bdd ->prepare('SELECT * FROM vocabulaire WHERE id =:id');
    $stmt->execute(['id'=>$id]);
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


