<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot ajoutés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
<?php
    require 'modele.php';

    $res = getBaseDD2();

        ?>

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
                        <h6 class="text-center">Created</h6>
                    </div>
                    <div class="col-4 p-0"> 
                        <h6 class="text-center"> approuved</h6>
                    </div>
                    <!-- <div class="col-2 ">
                        <h6 class="text-center"> Date de création</h6>
                    </div> -->
                </div>
                
            
                <?php foreach($res as $log_words):
                    ?>
                    <div class=" d-flex align-items-center p-1 row m-0">

                            <p class="col-1 text-center p-0 m-0 text-break" id="user <?=$log_words['id']?>"><?=$log_words['user']?></p>
                            <p class="col-1 text-center p-0 m-0 text-break" id="classe <?=$log_words['id']?>"><?=$log_words['classe']?></p>
                            <p class="col-2 text-center p-0 m-0 text-break" id="mot_en <?=$log_words['id']?>"><?=$log_words['mot_en']?></p>
                            <p class="col-2 text-center p-0 m-0 text-break" id="mot_fr <?=$log_words['id']?>"><?=$log_words['mot_fr']?></p>
                            <time class=" col-2 text-center"><?=$log_words['created']?></time>
                            <button class="col-2 text-center p-0 m-0 text-break" id="is_approved <?=$log_words['is_approved']?>"> oui </button>
                            <button class="col-2 text-center p-0 m-0 text-break" id="is_approved <?=$log_words['is_approved']?>"> non</button>
                    </div>
                <?php endforeach; ?>
            </div>
           
        </header>
</body>
</html>