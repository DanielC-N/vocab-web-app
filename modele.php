<?php
function getBaseDD(){
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt =$bdd->prepare('SELECT * FROM vocabulaire ORDER BY mot_fr ');
    $stmt->execute(); 
    $res = $stmt->fetchAll();
    $bdd = null;
    $stmt= null;
    return $res;
}

function getWordsByOffset($nbpage){
    $offset = $nbpage*20;
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt =$bdd->prepare('SELECT * FROM vocabulaire ORDER BY mot_en LIMIT 20 OFFSET :offset');
    $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetchAll();
    $bdd = null;
    $stmt= null;
    return $res;
}

function filterWord($text){
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt =$bdd ->prepare("SELECT * FROM vocabulaire WHERE mot_en LIKE :en OR mot_fr LIKE :fr ");
    $stmt->execute(['en'=>'%'.$text.'%', 'fr'=>'%'.$text.'%']);
    $res = $stmt->fetchAll();
    $bdd = null;
    $stmt= null;
    return $res;
 }

function deleteWord($id){
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt =$bdd ->prepare('DELETE FROM vocabulaire WHERE id =:id');
    $stmt->execute(['id'=>$id]);
}

function insertWord($textfr, $texten, $note){
    $bdd = new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt= $bdd->prepare('SELECT id FROM vocabulaire WHERE mot_en =:en');
    $stmt->execute(['en'=>$texten]);
    $r= $stmt->fetchAll();
    if(count($r)==0){
        $stmt= $bdd->prepare('INSERT INTO vocabulaire (mot_fr,mot_en,note) VALUES(:fr, :en, :note)');
        $stmt->execute(['fr'=> $textfr,'en'=>$texten,'note'=>$note]);
    } elseif (count($r)!=0) {
        echo("le mot existe déjà");
    }else {
      
    }
    // } else {
    //     $id=$r[0]['id'];
    //     $stmt=$bdd->prepare('UPDATE vocabulaire SET mot_fr=:fr, note=:note WHERE id=:id');
    //     $stmt->execute(['fr'=> $textfr,'note'=>$note, 'id'=>$id]); 
    $bdd = null;
    $stmt = null;
    }
   

 function updateWord($id, $textfr, $note, $numeroDeLaPage){

    $bdd=new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt= $bdd->prepare('UPDATE vocabulaire SET mot_fr=:fr, note=:note WHERE id=:id');
    $stmt->execute(['fr'=> $textfr,'note'=>$note, 'id'=>$id]);
    return getWordsByOffset($numeroDeLaPage);
}

function checkParams($fields){
    foreach($fields as $field){
        if ((!array_key_exists($field, $_POST))){
            return false;
        }
    }
    return true;
}
function getWord($id){
    $bdd=new PDO('mysql:host=localhost;dbname=traduction;','loise','formation');
    $stmt =$bdd->prepare('SELECT * FROM vocabulaire WHERE id=:id') ;
    $stmt->execute(['id'=>$id]);
}
?>


