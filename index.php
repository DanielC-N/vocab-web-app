<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Vocabulaire </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
        require 'modele.php';

        // declaration 
        $accueil=$_POST['rechercher'];
        if(array_key_exists('nbpage', $_GET) && $_GET['nbpage'] <0){
            $_GET['nbpage']=0;
        }
        $errormsg ="";
        $mode=$_POST['mode'];
        
        $nbPagesTotales=floor(count(getBaseDD())/20);
        if(array_key_exists('nbpage', $_GET) && $_GET['nbpage'] >= $nbPagesTotales) {
            $_GET['nbpage']= $nbPagesTotales -1;
        }
        $numeroPageCourante=$_GET['nbpage'];

        if(!isset($mode)|| $mode=="modification" ) {
            $resultats=getWordsByOffset($numeroPageCourante);
        }
        elseif($mode == "effacer") {
            if (!checkParams(['id'])){
                $errormsg=("id not found");
            } else {
                deleteWord($_POST['id']);
            }
            $resultats=getWordsByOffset($numeroPageCourante);
        }
        elseif($mode == "modifier") {
            if(!checkParams(['id','mot_fr','note'])) {
                $errormsg=('cannot be modified ');
            } else {
                $resultats=updateWord($_POST['id'],$_POST['mot_fr'],$_POST['note'],$nbPagesCourante);
            }
        }    
        elseif($mode == "ajouter") {
            if (!checkParams(['mot_fr','mot-en','note'])) {
                $errormsg=("word not found");
            } else {
                insertWord($_POST['mot_fr'],$_POST['mot_en'],$_POST['note']);   
            }
            $resultats=getWordsByOffset($numeroPageCourante);
        } 
        elseif($numeroPageCourante) {
            $resultats=getWordsByOffset($_GET['nbpage']);
        }
        elseif($mode == "rechercher"){
            if (!checkParams(['rechercher'])) {
                $errormsg=("not found");
            } else {
                $resultats=filterWord($_POST['rechercher']);
            }              
        } else {
            $resultats=getWordsByOffset($nbPagesCourante);
        }

        ?>

</head>
<body>
        <nav class="navbar bg-body-tertiary ">
            <div class="container justify-content-center">
                <form class="d-flex"  method="post">
                        <input class="form-control me-2" value="<?= $_POST['rechercher'] ?>" type="search" name="rechercher" id="search" placeholder="rechercher..."/>
                        <input class="btn btn-outline-success" type="submit" name="mode" value="rechercher" ></input>
                </form>
            </div>        
        </nav>

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
            
        <nav aria-label="Page navigation example"class="pagination justify-content-center m-2 ">
            <form method="get" action="">
                <input  type="hidden" name="nbpage" value="<?=$numeroPageCourante -1?>"></input>
                <input  type="submit" class="btn btn-outline-success" value="precedent"></input>
            </form>
            <?php
                for($numPage=0; $numPage <= $nbPagesTotales; $numPage++): 
            ?>
                <?php if ($numPage == $numeroPageCourante) : ?>
                    <form method="get" action="">
                        <input type="hidden" name="nbpage" value="<?=$numPage?>"></input>
                        <input type="submit" class="btn btn-success" value="<?=$numPage +1?>"></input>
                    </form>
                <?php else : ?>
                    <form method="get" action="">
                        <input type="hidden" name="nbpage" value="<?=$numPage?>"></input>
                        <input type="submit" class="btn btn-outline-success" value="<?=$numPage +1?>"></input>
                    </form>
                <?php endif ?>
            <?php endfor ?>
            <form method="get" action="">
                <input type="hidden" name="nbpage" value="<?=$numeroPageCourante+1?>"></input>
                <input  type="submit" type="submit" class="btn btn-outline-success" value="suivant"></input>
            </form>
        </nav>


        <?php if (!$accueil=="rechercher"):?>
            <?php else: ?>
            <ul class="pagination justify-content-left m-2">
                <li><a class="btn btn-outline-success" href="index.php"> Retour à la page d'accueil </a></li> 
            </ul>
            <?php endif;?>

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
                  
                    ?>
                    <div class="row py-1 border-bottom ">
                            <p class="col-sm-12 col-lg-2 col-md-2 text-center" id="fr<?=$vocabulaire['id']?>"><?=$vocabulaire['mot_fr']?></p>
                            <p class="col-sm-12 col-lg-2 col-md-2 text-center" id="en<?=$vocabulaire['id']?>"><?=$vocabulaire['mot_en']?></p>
                            <p class="col-sm-12 col-lg-2 col-md-2 text-center" id="note<?=$vocabulaire['id']?>"><?=$vocabulaire['note']?></p>
                            <time class="col-sm-12 col-lg-2 col-md-2 text-center"><?=$vocabulaire['created']?></time>

                        <form action="" method="post" class="col-lg-2 col-sm-12 col-md-2 text-center">
                            <input type="hidden" name="id" value="<?=$vocabulaire['id']?>"></input>
                            <input class="btn btn-outline-success" type="submit" name="mode" value="effacer"  id="<?=$vocabulaire['id']?>"></input> 
                        </form>

                        <form method="post" action="" class="col-lg-2 col-sm-12 col-md-2 text-center">
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
                <li><a class="btn btn-outline-success" href="index.php"> Retour à la page d'accueil </a></li> 
            </ul>
            <?php endif;?>

    </main>

        <nav aria-label="Page navigation example"class="pagination justify-content-center m-2 ">
            <form method="get" action="">
                <input  type="hidden" name="nbpage" value="<?=$numeroPageCourante -1?>"></input>
                <input  type="submit" class="btn btn-outline-success" value="precedent"></input>
            </form>
            <?php
                for($numPage=0; $numPage <= $nbPagesTotales; $numPage++): 
            ?>
                <?php if ($numPage == $numeroPageCourante) : ?>
                    <form method="get" action="">
                        <input type="hidden" name="nbpage" value="<?=$numPage?>"></input>
                        <input type="submit" class="btn btn-success" value="<?=$numPage +1?>"></input>
                    </form>
                <?php else : ?>
                    <form method="get" action="">
                        <input type="hidden" name="nbpage" value="<?=$numPage?>"></input>
                        <input type="submit" class="btn btn-outline-success" value="<?=$numPage +1?>"></input>
                    </form>
                <?php endif ?>
            <?php endfor ?>
            <form method="get" action="">
                <input type="hidden" name="nbpage" value="<?=$numeroPageCourante+1?>"></input>
                <input  type="submit" type="submit" class="btn btn-outline-success" value="suivant"></input>
            </form>
        </nav>
</body>
</html>

      
