<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Vocabulaire </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="styles.css" rel="stylesheet">
    <?php
        require 'modele.php';
        // declaration 

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
        if($mode == "ajouter"){
            if (!checkParams(['mot_fr','mot_en','note'])) {

                $errormsg=("word not found");
            } else {
                insertWord($_POST['mot_fr'],$_POST['mot_en'],$_POST['note']);
            }
            $resultats=getWordsByOffset($numeroPageCourante);
          
         } 
        elseif($mode == "rechercher"){
            
            if (!checkParams(['rechercher'])){
                $errormsg=("not found");
            } else {
                $resultats=filterWord($_POST['rechercher']);
            }
        } else {
           $resultats=getWordsByOffset($numeroPageCourante);
        }

        // elseif($mode == "effacer"){
        //     if (!checkParams(['id'])){
        //         $errormsg=("id not found");
        //     } else {
        //         deleteWord($_POST['id']);
        //     }
        //     $resultats=getWordsByOffset($numeroPageCourante);
        //}
        // else {
        //     $resultats=getWordsByOffset($numeroPageCourante);
        // }
        // elseif($mode == "modifier"){
        //     if(!checkParams(['id','mot_fr','note'])){
        //         $errormsg=('cannot be modified ');
        //     } else {
        //         $resultats=updateWord($_POST['id'],$_POST['mot_fr'],$_POST['note'],$nbPagesCourante);
        //     }
        //     $resultats=getWordsByOffset($numeroPageCourante);
        // }
    ?>

</head>
<body>
        <nav class="navbar bg-body-tertiary">
            <div class="container justify-content-center">
                <form class="d-flex"  method="post">
                        <input class="form-control me-1" value="<?= $_POST['rechercher'] ?>" type="search" name="rechercher" id="search" placeholder="rechercher..."/>
                        <input class="btn btn-outline-success" type="hidden" name="mode" value="rechercher"></input>
                        <input class="btn btn-outline-success" type="submit" name="txt" value=" &#128269;"></input>
                </form>
            </div>
        </nav>

        <!-- ?php if($mode== "modification"):?>


        <nav class="navbar bg-body-tertiary">
            <div class="container justify-content-center">
                <form class="d-flex" method="post">
                    <input class="form-control me-1" id="en" type="text" class="text" value="?=($_POST['en'])?>" name="mot_en" placeholder="mot en anglais"disabled/>
                    <input class="form-control me-1" id="fr" type="text" class="text" value="?=($_POST['fr'])?>" name="mot_fr" placeholder="mot en français"/>
                    <input class="form-control me-1" id="inputnote" type="text" class="text" value="?=($_POST['inputnote'])?>" name="note" placeholder="note"/>
                    <input class="form-control me-1" type="hidden" name="id" value="?=($_POST['id'])?>"> </input>
                    <input class="btn btn-outline-success" name="mode" value="modifier" type="submit"></input>
                </form>
            </div>
        </nav>
        
        ?php else: ?> -->
       
        <nav class="navbar bg-body-tertiary">
            <div class="container justify-content-center">
                <form class="d-flex" method="post">
                    <input class="form-control me-1" id="en" type="text" class="text" name="mot_en" placeholder="mot anglais"/>
                    <input class="form-control me-1" id="fr" type="text" class="text" name="mot_fr" placeholder="mot français"/>
                    <input class="form-control me-1" id="inputnote" type="text" class="text" name="note" placeholder="note"/>
                    <input class="btn btn-outline-success" id="ajouter" name="mode" value="ajouter" type="submit"></input>
                </form>
            </div>
        </nav>
        <!-- ?php endif; ?> -->

        <nav aria-label="Page navigation example" class="navbar bg-body-tertiary pagination justify-content-center">
            <form method="get" action="">
                <input type="hidden" name="nbpage" value="<?= max($numeroPageCourante - 1, 0) ?>"></input>
                <input type="submit" class="btn btn-outline-success" value="&lsaquo;"></input>
            </form>

        <?php
            $startPage = max(0, $numeroPageCourante - 1);
            $endPage = min($nbPagesTotales, $numeroPageCourante + 1);

            if ($startPage > 0){
                echo '<form method="get" action="">
                        <input type="hidden" name="nbpage" value="0"></input>
                        <input type="submit" class="btn btn-outline-success" value="1"></input>
                    </form>';
                if ($startPage > 1){
                    echo '<span>...</span>';
                }
            }

            for ($numPage = $startPage; $numPage <= $endPage; $numPage++):
        ?>
            <?php if ($numPage == $numeroPageCourante): ?>
                <form method="get" action="">
                    <input type="hidden" name="nbpage" value="<?= $numPage ?>"></input>
                    <input type="submit" class="btn btn-success" value="<?= $numPage + 1 ?>"></input>
                </form>
            <?php else: ?>
                <form method="get" action="">
                    <input type="hidden" name="nbpage" value="<?= $numPage ?>"></input>
                    <input type="submit" class="btn btn-outline-success" value="<?= $numPage + 1 ?>"></input>
                </form>
            <?php endif; ?>
        <?php endfor; ?>
        
        <form method="get" action="">
            <input type="hidden" name="nbpage" value="<?= min($numeroPageCourante + 1, $nbPagesTotales) ?>"></input>
            <input type="submit" class="btn btn-outline-success" value="&rsaquo;"></input>
        </form>
        <?php
            if ($endPage < $nbPagesTotales) {
                if ($endPage < $nbPagesTotales - 1) {
                    echo '<span>...</span>';
                }
                echo '<form method="get" action="">
                    <input type="hidden" name="nbpage" value="' . $nbPagesTotales . '"></input>
                    <input type="submit" class="btn btn-outline-success" value="&raquo;"></input>
                    </form>';
            }
        ?>
          
          
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
            <div class="container-fuide overflow-x-hidden text-black">
                <div class="row-gap d-flex align-items-center p-1 bg-success bg-opacity-50 text-wrap" >
                    
                    <div class="col-3 p-0">  
                        <h6 class="text-center"> Mots anglais</h6>
                    </div>
                    <div class="col-3 p-0">
                        <h6 class="text-center"> Mots français</h6>
                    </div>
                    <div class="col-2 pe-1"> 
                        <h6 class="text-center"> Notes</h6>
                    </div>
                    <div class="col-2 pe-1"> 
                        <h6 class="text-center">Effacer</h6>
                    </div>
                    <div class="col-2 p-0"> 
                        <h6 class="text-center"> Modifier</h6>
                    </div>
                    <!-- <div class="col-2 ">
                        <h6 class="text-center"> Date de création</h6>
                    </div> -->
                </div>
                
            
                <?php foreach($resultats as $vocabulaire):
                        $rowType = $rowType == "odd" ? "even":"odd";

                    ?>
                    <div class=" d-flex align-items-center p-1 row m-0 <?=$rowType?>">

                            <p class="col-3 text-center p-0 m-0 text-break" id="en <?=$vocabulaire['id']?>"><?=$vocabulaire['mot_en']?></p>
                            <p class="col-3 text-center p-0 m-0 text-break" id="fr <?=$vocabulaire['id']?>"><?=$vocabulaire['mot_fr']?></p>
                            <p class="col-2 text-center p-0 m-0 text-break" id="note <?=$vocabulaire['id']?>"><?=$vocabulaire['note']?></p>

                        <form action="" method="post" class="col-2 text-center p-0">
                            <input type="hidden" name="id" value="<?=$vocabulaire['id']?>"></input>
                            <input type="hidden" name="mode" value="effacer"></input>
                            <input class="btn btn-outline-success" type="submit" name="txt" value="&#128465;" id="<?=$vocabulaire['id']?>"></input>
                        </form>

                        <form method="post" action="" class="col-2 text-center p-0">
                            <input type="hidden" name="id" value="<?=$vocabulaire['id']?>"></input>
                            <input type="hidden" name="en" value="<?=$vocabulaire['mot_en']?>"></input>
                            <input type="hidden" name="fr" value="<?=$vocabulaire['mot_fr']?>"></input>
                            <input type="hidden" name="inputnote" value="<?=$vocabulaire['note']?>"></input>
                            <input type="hidden" name="mode" value="modification"></input>
                            <input class="btn btn-outline-success" type="submit" name="txte" value="&#128394;"></input>
                        </form>
                        <!-- <time class=" col-2 text-center">?=$vocabulaire['created']?></time>-->
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

            <nav aria-label="Page navigation example" class="navbar bg-body-tertiary pagination justify-content-center">
        <form method="get" action="">
            <input type="hidden" name="nbpage" value="<?= max($numeroPageCourante - 1, 0) ?>"></input>
            <input type="submit" class="btn btn-outline-success" value="&lsaquo;"></input>
        </form>

        <?php
            $startPage = max(0, $numeroPageCourante - 1);
            $endPage = min($nbPagesTotales, $numeroPageCourante + 1);

            if ($startPage > 0) {
                echo '<form method="get" action="">
                        <input type="hidden" name="nbpage" value="0"></input>
                        <input type="submit" class="btn btn-outline-success" value="1"></input>
                    </form>';
                if ($startPage > 1) {
                    echo '<span>...</span>';
                }
            }

            for ($numPage = $startPage; $numPage <= $endPage; $numPage++):
        ?>
            <?php if ($numPage == $numeroPageCourante): ?>
                <form method="get" action="">
                    <input type="hidden" name="nbpage" value="<?= $numPage ?>"></input>
                    <input type="submit" class="btn btn-success" value="<?= $numPage + 1 ?>"></input>
                </form>
            <?php else: ?>
                <form method="get" action="">
                    <input type="hidden" name="nbpage" value="<?= $numPage ?>"></input>
                    <input type="submit" class="btn btn-outline-success" value="<?= $numPage + 1 ?>"></input>
                </form>
            <?php endif; ?>
        <?php endfor; ?>

        <form method="get" action="">
            <input type="hidden" name="nbpage" value="<?= min($numeroPageCourante + 1, $nbPagesTotales) ?>"></input>
            <input type="submit" class="btn btn-outline-success" value="&rsaquo;"></input>
        </form>


        <?php
            if ($endPage < $nbPagesTotales) {
                if ($endPage < $nbPagesTotales - 1) {
                    echo '<span>...</span>';
                }
                echo '<form method="get" action="">
                        <input type="hidden" name="nbpage" value="' . $nbPagesTotales . '"></input>
                        <input type="submit" class="btn btn-outline-success" value="&raquo;"></input>
                    </form>';
            }
        ?>
    </nav>
        <!-- ?php if($mode== "ajouter"): ?> 
            ?php var_dump($_POST);
            if (!checkParams(['mot_fr','mot_en','note'])) {

                $errormsg=("word not found");
            } else {
                insertWord($_POST['mot_fr'],$_POST['mot_en'],$_POST['note']);
            }
            $resultats=getWordsByOffset($numeroPageCourante);
             ?>
        ?php else: ?>
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="..." class="rounded me-2" alt="...">
                    <strong class="me-auto">Bootstrap</strong>
                    <small>11 mins ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Le mot existe déjà ! 
                </div>
            </div>
        ?php if(isset($errormsg)) ?>
            <div class="alert alert-danger" role="alert">
                ?= $errormsg;?>
            </div>
        ?php endif; ?>
             -->


             <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <!-- <div class="toast-header">
                    <strong class="me-auto">Bootstrap</strong>
                    <small>11 mins ago</small>
                    <button type="button"  class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div> -->
                <div class="toast-body">
                    Le mot existe déjà !
                </div>
            </div>

</body>
<script>
    let collectionOfText = document.getElementsByClassName('text-break');

    for (let i = 0; i < collectionOfText.length; i++) {
        collectionOfText[i].addEventListener('dblclick', (e) => {
            let textToCopy = e.target.innerText;
            navigator.clipboard.writeText(textToCopy).then(() => {
                console.log(`Copier dans le presse papier: ${textToCopy}`);
            });
        });
    }
</script>
</html>