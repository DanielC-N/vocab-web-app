<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Vocabulaire </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <?php $accueil=$_POST['rechercher']; ?> 

        <nav class="navbar bg-body-tertiary ">
            <div class="container justify-content-center">
                <form class="d-flex"  method="post">
                        <input class="form-control me-2" value="<?= $_POST['rechercher'] ?>" type="search" name="rechercher" id="search" placeholder="rechercher..."/>
                        <input class="btn btn-outline-success" type="submit" name="mode" value="rechercher" ></input>
                </form>
            </div>        
        </nav>
        <?php    $errormsg ="";
                $mode=$_POST['mode'];
                
        ?>
        <?php if($mode== "modification"):?>


        <nav class="navbar bg-body-tertiary">
            <div class="container justify-content-center">
                <form class="d-flex" method="post">
                    <input class="form-control me-2" id="fr" type="text" class="text" value="<?=($_POST['fr'])?>" name="mot_fr" placeholder="mot en français"/>
                    <input class="form-control me-2" id="en" type="text" class="text"  value="<?=($_POST['en'])?>" name="mot_en" placeholder="mot en anglais"disabled/>
                    <input class="form-control me-2" id="inputnote" type="text" class="text"  value="<?=($_POST['inputnote'])?>" name="note" placeholder="note"/>
                    <input class="form-control me-2" type="hidden" name="id" value="<?=($_POST['id'])?>"> </input>
                    <input class="btn btn-outline-success" name="mode" value="modifier" type="submit"></input>
                </form>
            </div>
        </nav>
        
        <?php else: ?>
       
        <nav class="navbar bg-body-tertiary">
            <div class="container justify-content-center">
                <form class="d-flex" method="post">
                    <input class="form-control me-2 " id="fr" type="text" class="text" name="mot_fr" placeholder="mot en français"/>
                    <input class="form-control me-2" id="en" type="text" class="text" name="mot_en" placeholder="mot en anglais"/>
                    <input class="form-control me-2" id="inputnote" type="text" class="text" name="note" placeholder="note"/>
                    <input class="btn btn-outline-success" id="ajouter" name="mode" value="ajouter" type="submit"></input>
                </form>
            </div>
        </nav>
        <?php endif; ?>

        <?php if (!$accueil=="rechercher"):?>
            <?php else: ?>
            <ul class="pagination justify-content-left m-2">
                <li class="page-item"><a class="page-link text-success" href="index.php"> Retour à la page d'accueil </a></li> 
            </ul>
            <?php endif;?>
<?php
    function checkParams($fields){
        foreach($fields as $field){
            if ((!$_POST[$field])){
                return false;
            }
        }
        return true;
    }

    require 'modele.php';

    if(!isset($mode)|| $mode=="modification" ){
        var_dump($_POST);
       $resultats=getWordsByOffset();
    }
    elseif($mode == "effacer"){
        
        if (!checkParams(['id'])){

            $errormsg=("id not found");
        }else{

            deleteWord($_POST['id']);
        }
        $resultats=getBaseDD();
    }
    elseif($mode == "modifier"){
        
        if(!checkParams(['id']['mot_fr'],['mot_en'],['note'])){
          
            $errormsg=('cannot be modified '); 
        }
        else{
            $resultats=updateWord($_POST['id'],$_POST['mot_fr'],$_POST['note']);
        
        }
    }    
    elseif($mode == "ajouter"){

        if (!checkParams(['mot_fr'],['mot-en'],['note'])){

            $errormsg=("word not found");
        }
        else{
              insertWord($_POST['mot_fr'],$_POST['mot_en'],$_POST['note']);
            
        }
        $resultats=getBaseDD();
    }
    elseif($mode == "rechercher"){

        if (!checkParams(['rechercher'])) {
            $errormsg=("not found");
        } else{
            $resultats=filterWord($_POST['rechercher']);
        }        
            
    } else {
        $resultats=getBaseDD();
    }

    $rowType="odd";
?>

<?php if ($errormsg): ?> 
    <h1>error : <?=$errormsg?></h1>
    <?php endif; ?>
        <header>
    
            <div class="container-fuide border">
                <div class="row py-2 border-bottom bg-success bg-opacity-50 ">
                    <div class="col-lg-2 col-sm-2 col-md-2 ">  
                        <h6 class="text-center"> Mots français</h6>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-md-2">  
                        <h6 class="text-center"> Mots anglais</h6>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-md-2"> 
                        <h6 class="text-center"> Notes</h6>
                    </div>
                    <div class="col-lg-2col-sm-2 col-md-2">  
                        <h6 class="text-center"> Date de création</h6>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-md-2"> 
                        <h6 class="text-center"> Effacer</h6>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-md-2"> 
                        <h6 class="text-center"> Modification</h6>
                    </div>
                </div>
            
                <?php foreach($resultats as $vocabulaire):
                    $rowType = $rowType == "odd" ? "even":"odd";
                    ?>
                    <div class="row py-1 border-bottom ">
                            <p class="col-sm-12 col-lg-2 col-md-2 text-center <?= $rowType?>" id="fr<?=$vocabulaire['id']?>"><?=$vocabulaire['mot_fr']?></p>
                            <p class="col-sm-12 col-lg-2 col-md-2 text-center <?= $rowType?>" id="en<?=$vocabulaire['id']?>"><?=$vocabulaire['mot_en']?></p>
                            <p class="col-sm-12 col-lg-2 col-md-2 text-center <?= $rowType?>" id="note<?=$vocabulaire['id']?>"><?=$vocabulaire['note']?></p>
                            <time class="col-sm-12 col-lg-2 col-md-2 text-center <?= $rowType?>"><?=$vocabulaire['created']?></time>

                        <form action="" method="post" class="col-lg-2 col-sm-12 col-md-2 text-center <?= $rowType?>">
                            <input type="hidden" name="id" value="<?=$vocabulaire['id']?>"></input>
                            <input class="btn btn-outline-success" type="submit" name="mode" value="effacer"  id="<?=$vocabulaire['id']?>"></input> 
                        </form>

                        <form method="post" action="" class="col-lg-2 col-sm-12 col-md-2 text-center <?= $rowType?>">
                            <input type="hidden" name="id" value="<?=$vocabulaire['id']?>"></input>
                            <input type="hidden" name="fr" value="<?=$vocabulaire['mot_fr']?>"></input>
                            <input type="hidden" name="en" value="<?=$vocabulaire['mot_en']?>"></input>
                            <input type="hidden" name="inputnote" value="<?=$vocabulaire['note']?>"></input>
                            <input class="btn btn-outline-success" type="submit" name="mode" value="modification"></input>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
           
        </header> 

            <?php if (!$accueil=="rechercher"):?>
            <?php else: ?>
            <ul class="pagination justify-content-left m-2">
                <li class="page-item"><a class="page-link text-success" href="index.php"> Retour à la page d'accueil </a></li> 
            </ul>
            <?php endif;?>

    </main>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center m-2">
            <li class="page-item disabled">
            <a class="page-link text-success " href="#">precedent</a>
            </li>
            <li class="page-item"><a class="page-link text-success" href="#">1</a></li>
            <li class="page-item"><a class="page-link text-success" href="#">2</a></li>
            <li class="page-item"><a class="page-link text-success" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link text-success " href="#">suivant</a>
            </li>
        </ul>
    </nav>
</body>
</html>
