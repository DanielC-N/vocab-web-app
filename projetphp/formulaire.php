<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>modification</title>


</head>
<body>
    <main>             
<?php
    require 'modele.php';

    if($_POST['mot_fr'][0]!="" && $_POST['mot_en'][0]!="" && $_POST['note'][0]!=""){      
        updateWord($_POST['id'],$_POST['mot_fr'],$_POST['mot_en'],$_POST['note']);
    }

    if($_POST['id']!="") {
        $id = $_POST['id'];
        $resultats = getWord($id);
        foreach($resultats as $vocabulaire);
        }

      
        // if($_POST['update']!="") {
        //     $id = $_POST['id'];
        //     $resultats = updateWord($id);
        // }
        // echo($_POST['id'])
    // if($_POST['mot_fr'][0]!="" && $_POST['mot_en'][0]!="" && $_POST['note'][0]!=""){
    //     insertWord($_POST['mot_fr'],$_POST['mot_en'],$_POST['note']);
    // } else {
    //     $resultats = getBaseDD();
    // }
    
    // $rowType="odd";
    //var_dump($vocabulaire); ?>
   
        <form method="post" >
            <div id="dynamicFields">
                <div class="row">
                        <input id="fr" type="text" class="text" name="mot_fr" placeholder="mot en français" value=<?= $vocabulaire['mot_fr']?>>
                        <input id="en" type="text" class="text" name="mot_en" placeholder="mot en anglais" value=<?= $vocabulaire['mot_en']?>>
                        <input id="inputnote" type="text" class="text" name="note" placeholder="notes" value=<?= $vocabulaire['note']?>>
                        <input type="hidden" name="id" value="<?=$vocabulaire['id']?>"></input>

                        <button id="boutonmodif" class="button" name="update"> modifier</button>
                </div>
            <div>
        </form>
        <a href="index.php">ici</a>
    </main>
  
</body>
</html>
