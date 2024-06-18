<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mots ajoutés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
<?php

    // if ($_SERVER['PHP_AUTH_USER'] != "xenizo") { 
    //     header('Location:index.php');
    //     exit();
    // }

    require 'modele.php';
    
    $res = getBaseDD2();

        $nbPagesTotales=floor(count(getBaseDD())/20);
        if(array_key_exists('nbpage', $_GET) && $_GET['nbpage'] >= $nbPagesTotales){
            $_GET['nbpage']= $nbPagesTotales;
        }
        $numeroPageCourante=$_GET['nbpage'];

        $errormsg ="";
        $mode=$_POST['mode'];

        $accueil=$_POST['rechercher'];
        if(array_key_exists('nbpage', $_GET) && $_GET['nbpage'] <0){
            $_GET['nbpage']=0;
        }
        // if(!isset($mode)|| $mode=="modification"){
        //     $resultats=getWordsByOffset($numeroPageCourante);
        // }
        // if($mode == "ajouter"){
        //     if (!checkParams(['mot_fr','mot_en','note'])) {

        //         $errormsg=("word not found");
            
        //     } elseif($_POST['mot_fr']== "" || $_POST['mot_en']=="") {
        //         $errormsg=("please don't leave the fields for French and English words empty");
        //         $resultats=getWordsByOffset($numeroPageCourante);

        //     } else {
        //         $doesExist = insertWord($_POST['mot_fr'],$_POST['mot_en'],$_POST['note']);
            
        //     }

        //     $resultats=getWordsByOffset($numeroPageCourante);
            
        // } elseif($mode == "rechercher"){
        //     if (!checkParams(['rechercher'])){

        //         $errormsg=("not found");

        //     } elseif($_POST['rechercher']== "") {

        //     $resultats=getWordsByOffset($numeroPageCourante);
        //     }else{
        //         $resultats=filterWord($_POST['rechercher']);
        //     }
        // } 
        // elseif($mode == "effacer"){
        //     if (!checkParams(['id'])){
        //         $errormsg=("id not found");
        //     } else {
        //         deleteWord($_POST['id']);
        //     }
        //     $resultats=getWordsByOffset($numeroPageCourante);}
        // } elseif($mode == "modifier"){
        //     if(!checkParams(['id','mot_fr','note'])){
        //         $errormsg=('cannot be modified ');
        //     } else {
        //         $resultats=updateWord($_POST['id'],$_POST['mot_fr'],$_POST['note'],$nbPagesCourante);
        //     }
        //     $resultats=getWordsByOffset($numeroPageCourante);
        // } 
        // else {
        //     $resultats=getWordsByOffset($numeroPageCourante);}
    
    //    if($mode=="oui"){
    //     var_dump($_POST);
    //         insertWordLog($_POST['id']);
    //    } 
    
        if($mode == "oui"){
            var_dump($_POST);
            if (!checkParams(['mot_fr','mot_en','note','id'])) {

                $errormsg=("word not found");

            } else {
                $doesExist = insertWordLog($_POST['mot_fr'],$_POST['mot_en'],$_POST['note']);
            
            }
        } else {
            
            echo "non "; }

            if($doesExist == 'exists'):
                $errormsg= "This word already exists"?>
        <?php endif; ?>
    
<header>
            <div class="container-fuide overflow-x-hidden text-black">
                <div class="row-gap d-flex align-items-center p-1 bg-success bg-opacity-50 text-wrap" >
                    
                    <div class="col-1 p-0">  
                        <h6 class="text-center"> User</h6>
                    </div>
                    <div class="col-1 pe-1"> 
                        <h6 class="text-center"> Classe</h6>
                    </div>
                    <div class="col-2 p-0">
                        <h6 class="text-center"> Mots anglais</h6>
                    </div>
                    <div class="col-2 p-0">
                        <h6 class="text-center"> Mots français</h6>
                    </div>
                    <div class="col-2 pe-1"> 
                        <h6 class="text-center">Notes</h6>
                    </div>
                    <div class="col-2 pe-1"> 
                        <h6 class="text-center">Created</h6>
                    </div>
                    <div class="col-2 p-0"> 
                        <h6 class="text-center"> approved</h6>
                    </div>
                </div>
                
                <?php foreach($res as $log_words):
                    ?>
                     
                    <div  class="d-flex align-items-center p-1 row m-0">

                            <p class="col-1 text-center p-0 m-0 text-break" id="user <?=$log_words['id']?>"><?=$log_words['user']?></p>
                            <p class="col-1 text-center p-0 m-0 text-break" id="classe <?=$log_words['id']?>"><?=$log_words['classe']?></p>
                            <p class="col-2 text-center p-0 m-0 text-break" name="mot_en" id="mot_en <?=$log_words['id']?>"><?=$log_words['mot_en']?></p>
                            <p class="col-2 text-center p-0 m-0 text-break" name="mot_fr" id="mot_fr <?=$log_words['id']?>"><?=$log_words['mot_fr']?></p>
                            <p class="col-2 text-center p-0 m-0 text-break" name="note" id="note <?=$log_words['id']?>"><?=$log_words['note']?></p>

                            <time class="col-2 text-center"><?=$log_words['created']?></time>

                            <form method="post" class="col-2 text-center p-0 m-0 text-break" >
                                <input type ="hidden" id="user <//?=$log_words['id']?>" value="<?=$log_words['user']?>" ></input>
                                <input type ="hidden" id="classe <//?=$log_words['id']?>" value="<?=$log_words['classe']?>" ></input> 
                                <input type="hidden" name="mot_en" id="mot_en <?=$log_words['id']?>" value="<?=$log_words['mot_en']?>"></input>
                                <input type ="hidden" name="mot_fr" id="mot_fr <?=$log_words['id']?>" value="<?=$log_words['mot_fr']?>" ></input>
                                <input type ="hidden" name="note" id="note <?=$log_words['id']?>" value="<?=$log_words['note']?>" ></input>
                                <input type="hidden" name="id" value="<?=$log_words['id']?>"></input>
                                <input type="hidden" name="mode" value="oui"></input>
                                <input type="submit" name="txt" class="col-2 text-center p-0 m-0" value="ok"></input>
                            </form>  

                    </div>
                    
                <?php endforeach; ?>
            </div>
        </header>
</body>
</html>